<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use App\Repository\ProduitRepository;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\Translation\TranslatorInterface;

class CartController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, Security $security): Response
    {
        return $this->render('cart/index.html.twig', [
            
            'cart' => $session->get('panier')
        ]);
    }
    #[Route('/add-to-cart/{id}', name: 'add_to_cart', methods: ['GET'])]
    public function addToCart(int $id,Produit $produit, SessionInterface $session,EventDispatcherInterface $eventDispatcher,ProduitRepository $produitRepository,TranslatorInterface $translator): RedirectResponse
    {
       // Get the cart from the session or create an empty array if it doesn't exist
       $cart = $session->get('cart', []);

       // Check if the product is already in the cart
       $productId = $produit->getId();
       if (isset($cart[$productId])) {
           // If the product is already in the cart, increment the quantity
           $cart[$productId]++;
       } else {
           // If the product is not in the cart, add it with quantity 1
           $cart[$productId] = 1;
       }

       // Store the updated cart back into the session
       $session->set('cart', $cart);

       $produit = $produitRepository->find($id);
       $this->addFlash('success', sprintf('"%s" ajouté au panier.', $produit->getTitre()));
   

       // Redirect back to the product page or any other desired route
       return $this->redirectToRoute('app_produit_show', ['id' => $produit->getId()]);
    }
    #[Route('/show-cart', name: 'show_cart', methods: ['GET'])]
    public function showCart(SessionInterface $session,ProduitRepository $produitRepository )
    {
        // Get the cart from the session or create an empty array if it doesn't exist
        $cart = $session->get('cart', []);

        // Fetch the products (produits) from the database using the product IDs in the cart
        $productIds = array_keys($cart);
        $produits = $produitRepository->findBy(['id' => $productIds]);

        // Calculate the total for each product and the overall total
        $totalAmount = 0;
        foreach ($produits as $produit) {
            $quantity = $cart[$produit->getId()];
            $totalAmount += $produit->getPrix() * $quantity;
        }

        return $this->render('cart/show.html.twig', [
            'produits' => $produits,
            'cart' => $cart,
            'totalAmount' => $totalAmount,
        ]);
    }
    #[Route('/clear-cart', name: 'clear_cart', methods: ['POST'])]
    public function clearCart(SessionInterface $session): JsonResponse
    {
        // Clear the cart data from the session
        $session->remove('cart');

        return new JsonResponse(['success' => true]);
    }
    
    #[Route('/update-cart/{id}', name: 'update_cart', methods: ['POST'])]
    public function updateCart(int $id, SessionInterface $session): RedirectResponse
    {
        $action = $_POST['action'] ?? null;

        if ($action === 'increase') {
            $this->changeQuantity($id, $session, 1);
        } elseif ($action === 'decrease') {
            $this->changeQuantity($id, $session, -1);
        }

        return $this->redirectToRoute('show_cart');
    }

    private function changeQuantity(int $id, SessionInterface $session, int $changeBy): void
    {
        // Get the cart from the session or create an empty array if it doesn't exist
        $cart = $session->get('cart', []);

        // Check if the product ID exists in the cart
        if (array_key_exists($id, $cart)) {
            // If the product is in the cart, update the quantity
            $cart[$id] += $changeBy;

            // Ensure the quantity is not negative
            $cart[$id] = max(0, $cart[$id]);
        }

        // Store the updated cart back into the session
        $session->set('cart', $cart);
    }

    // ...
}

