<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue', methods: ['GET'])]
    public function index(Request $request,ProduitRepository $produitRepository): Response
    {
        $searchTerm = $request->query->get('t');
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'produits' => $produitRepository->findBytitle($searchTerm),
            'searchTerm' => $searchTerm,
            
        ]);
    }
}
