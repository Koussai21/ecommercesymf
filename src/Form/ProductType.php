<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom du produit',
                'required' => false,
                'help' => 'Saisir un nom de produit entre 4 et 25 caractères',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom du produit'
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Veuillez saisir un nom d\'au moins 4 caractères',
                        'max' => 25,
                        'maxMessage' => 'Veuillez saisir un nom de moins de 25 caractères'
                    ])
                ]
            ])
            ->add('price', MoneyType::class,[
                'currency' => 'USD',
                'label' => 'Prix du produit',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le prix du produit'
                    ]),
                    new Positive([
                        'message' => 'Veuillez saisir un prix strictement supérieur à zéro'
                    ])
                    
                ]
            ])
            ->add('description', null, [
               // k => v
                'label' => false,
                'help' => 'Écrire une description du produit',
                'help_attr' => [
                   'class' => 'text-info'
                ],
                'attr' => [
                    'placeholder' => 'saisir une description',
                    'class' => 'bg-light'
                ],
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 200,
                        'maxMessage' => 'Veuillez saisir un description de moins de 200 caractères'
                    ])
                ]
            ])
            // ->add('Ajouter', SubmitType::class)

            /*
               methode add()
               1- nom de la propriété dans l'entity
               2- nom de la class Type
               3- tableau des options de configuration
                  Il existe 2 types d'options :
                  - options universelles
                  - options propres à la class
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
