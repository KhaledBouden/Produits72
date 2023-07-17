<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;

class SecuirityController extends AbstractController
{
    #[Route('/connexion', name:'security.login',methods:['GET', 'POST'])]
    public function login(): Response
    {
        return $this->render('secuirity/login.html.twig', [
            'controller_name' => 'SecuirityController',
        ]);
    }
    #[Route('/inscription','secuirity.registration',methods:['GET', 'POST'])]
    public function registration(Request $request,EntityManagerInterface $manager) : Response {
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush($user);
            return $this->redirectToRoute('app_login'); 
        }
        return $this->render('secuirity/registration.html.twig',[
            'form' =>$form->createView()
        ]);
    }
}
