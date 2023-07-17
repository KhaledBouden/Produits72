<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr' => [
                    'class' =>'form-control' 
                ]
            ])
            
            ->add('plainPassword',PasswordType::class,[
                'label' => "Mot de passe",
                'attr' => [
                    'class' => 'form-control'
                    
                ]
            ])
            ->add('fullname',TextType::class,[
                'label'=> 'Nom et Prenom',
                'attr' => [
                    'class' => 'form-control'
                    
                ]
            ])
            ->add('birthday',DateType::class,[
                'label'=> 'Date de naisance',
                'attr' => [
                    
                    
                ]
            ])
            ->add('adresse',TextType::class,[
                'label'=> 'Adresse de résidence',
                'attr' => [
                    'class' => 'form-control'
                    
                ]
                ])
            ->add('phoneNumber',TextType::class,[
                'label'=> 'Numéro de Téléphone',
                'attr' => [
                    'class' => 'form-control'
                    
                ]
                ])
            ->add('submit', SubmitType::class,[
                'label'=> "s'inscrire",
                'attr' =>[
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
