<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez remplir ce champ'
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Titre invalide !'
                ])
                ],
            'attr' => ['placeholder' => 'Titre'],
        ])
        ->add('description', TextareaType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez remplir ce champ'
                ]),
                new Length([
                    'min' => 5,
                    'minMessage' => 'Description invalide !'
                ])
                ],
            'attr' => ['placeholder' => 'Description de l\'annonce'],
        ])
        ->add('image', FileType::class, [
            'label' => 'image',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new Image([
                    'maxSize' => '16384k',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpeg',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid png or jpeg document',
                ])
            ],
        ])
        
        ->add('categorie', EntityType::class, [
            'class' => Categorie::class,
            'choice_label' => 'title'])
           
       
        ->add('submit', SubmitType::class,[
            'attr' => ['class' => 'btn btn-success '],
            'label' => 'Poster'
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
