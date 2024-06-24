<?php

// src/Form/ProduitType.php
namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('price', NumberType::class)
            ->add('categorie', ChoiceType::class, [
                'choices'  => [
                    'Boisson' => 'boisson',
                    'Tapas' => 'tapas',
                    'Dessert' => 'dessert',
                ],
                'placeholder' => 'Sélectionnez une catégorie', // Optionnel: Ajoute une option vide par défaut
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder'
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
