<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Entity\Produit;
use App\Form\ProduitType;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'produits' => $produitRepository->findAll(),
            
        ]);
    }
}
