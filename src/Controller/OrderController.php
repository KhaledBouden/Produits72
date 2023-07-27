<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,ProduitRepository $produitRepository,SessionInterface $session, Security $security): Response
    {   
           // Get the current user (you can use Symfony's Security component)
           $user = $security->getUser();

           // Get the cart from the session using the session property
           $cart = $session->get('cart', []);
           $productIds = array_keys($cart);
           $produits = $produitRepository->findBy(['id' => $productIds]);
   
           $order = new Order();
           $order->setClientName($user->getFullName());
           $order->setClientAdresse($user->getAdresse());
           $order->setClientPhone($user->getPhoneNumber());
   
           $productQuantities = [];
           foreach ($produits as $produit) {
               $quantity = $cart[$produit->getId()]; // Get the quantity from the cart
               $order->addProduct($produit); // Add the product to the order
               $produit->addOrder($order); // Add the order to the product (bi-directional relationship)
               // Store the quantity for the product using the product ID as the key
               $productQuantities[$produit->getId()] = $quantity;
               $produit->setQuantity($produit->getQuantity() - $productQuantities[$produit->getId()]);
               if($produit->getQuantity() < 0)
               $produit->setQuantity(0);
           }
   
           $order->setProductQuantities($productQuantities);
   
           $entityManager->persist($order);
           $entityManager->flush();
   
           // Clear the cart after successfully placing the order
           $session->set('cart', []);
   
           return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
       }
    

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/add', name: 'app_order_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager,ProduitRepository $produitRepository){
        
       
        
        
    }
}
