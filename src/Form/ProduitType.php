<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('marque')
            ->add('type')
            ->add('description')
            ->add('prix')
            ->add('volume')
            ->add('quantity')
            ->add('fiche')
            ->add('soldWith')
            ->add('imageFile',VichImageType::class,[
                'required' => false, 
                'label' => 'Image du produit',
                'label_attr' =>
                [
                    'class' => 'form-label mt-4 '
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
