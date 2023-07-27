<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class OrdersController extends AbstractController
{

 

    #[Route('/orders', name: 'app_orders')]
    public function index(): Response
    {
        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }
    #[Route('/place-order', name: 'place_order')]
    public function placeOrder(EntityManagerInterface $entityManager,SessionInterface $session, Security $security): Response
    {
        // Get the current user (you can use Symfony's Security component)
        $user = $security->getUser();

        // Get the cart from the session using the session property
        $cart = $session->get('panier', []);

        // Create a new Order instance
        $order = new Order();
        $order->setClientName($user->getFullName());
        $order->setClientAdresse($user->getAdresse());
        $order->setClientPhone($user->getPhoneNumber());

        // Add products from the cart to the Order
        foreach ($cart as $produit) {
            if ($produit instanceof Produit) {
                $order->addProduct($produit);
            }
        }

        // Persist and flush the Order entity to the database
        $entityManager->persist($order);
        $entityManager->flush();

        // Clear the cart after the order is placed (optional)
        $this->clearCart($session);

        // Redirect to a success page or show a success message
        return $this->redirectToRoute('app_orders');
    }

    // Implement the following methods according to your application's logic:

  

    private function clearCart(SessionInterface $session)
    {
        // Clear the cart in the session after the order is placed
        // Replace this with your actual logic
        $session->set('cart', []);
    }
}
