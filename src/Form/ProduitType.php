<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Produit;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if($options['ajouter'] == true)
        {
            $builder
                ->add('titre', TextType::class , [

                    "label" => "Titre du produit",
                    "required" => false,
                    "attr" => [
                        "class" => "titreProduit",
                        "placeholder" => "Saisir le titre du produit",
                        // 'rows' => 10 
                    ],

                    // "constraints" => [
                    //     new NotBlank([
                    //         'message' => "Veuillez saisir un titreeeeeeee",
                    //     ]),
                    //     new Length([
                    //         'min' => 5,
                    //         'max' => 10,
                    //         'minMessage' => "5 caractères min",
                    //         'maxMessage' => "10 caractères max"
                    //     ])
                    // ]


                ])
                ->add('prix', MoneyType::class, [
                    "label" => "Prix du produit (€)",
                    "required" => false,
                    "attr" => [
                        "class" => "prixProduit",
                        "placeholder" => "Saisir le prix du produit"
                    ]
                ])
                ->add('image', FileType::class, [
                    "required" => false,
                    "constraints" => [
                        new File([
                            'mimeTypes' => [
                                "image/png",
                                "image/jpg",
                                "image/jpeg"
                            ],
                            "mimeTypesMessage" => "Extensions autorisées : PNG - JPG "
                        ])
                    ]
                ])


                ->add('category', EntityType::class, [ // cet input a une relation avec une autre entity
                    "class" => Category::class,        // avec quelle entity
                    "choice_label" => "nom",          // quelle propriété (quel champ) afficher
                    'query_builder' => function(CategoryRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.nom', 'DESC');
                    },
                ] )


                ->add("matieres", EntityType::class, [
                    "class" => Matiere::class,
                    "choice_label" => "nom",
                    "multiple" => true, // avec ManyToMany obligatoirement ajouter multiple true
                    //"expanded" => true // les checkbox
                    "attr" => [
                        "class" => "select2"
                    ]
                ])

                ->add('stock', IntegerType::class , [

                    "label" => "Stock du produit",
                    "required" => false,
                    "attr" => [
                        "value" => 0
                    ],
                ])



                
                // ->add('Ajouter', SubmitType::class )
            ;
        }


        elseif($options['modifier'] == true)
        {
            $builder
                ->add('titre', TextType::class , [

                    "label" => "Titre du produit",
                    "required" => false,
                    "attr" => [
                        "class" => "titreProduit",
                        "placeholder" => "Saisir le titre du produit",
                        // 'rows' => 10 
                    ],

                    // "constraints" => [
                    //     new NotBlank([
                    //         'message' => "Veuillez saisir un titreeeeeeee",
                    //     ]),
                    //     new Length([
                    //         'min' => 5,
                    //         'max' => 10,
                    //         'minMessage' => "5 caractères min",
                    //         'maxMessage' => "10 caractères max"
                    //     ])
                    // ]


                ])
                ->add('prix', MoneyType::class, [
                    "label" => "Prix du produit (€)",
                    "required" => false,
                    "attr" => [
                        "class" => "prixProduit",
                        "placeholder" => "Saisir le prix du produit"
                    ]
                ])
                ->add('imageFile', FileType::class, [
                    "required" => false,
                    "mapped" => false, // ce n'est pas une propriété provenant de l'entity produit
                    "constraints" => [
                        new File([
                            'mimeTypes' => [
                                "image/png",
                                "image/jpg",
                                "image/jpeg"
                            ],
                            "mimeTypesMessage" => "Extensions autorisées : PNG - JPG "
                        ])
                    ]
                ])

                ->add('category', EntityType::class, [ // cet input a une relation avec une autre entity
                    "class" => Category::class,        // avec quelle entity
                    "choice_label" => "nom",          // quelle propriété (quel champ) afficher
                    'query_builder' => function(CategoryRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.nom', 'DESC');
                    },
                ] )

                ->add("matieres", EntityType::class, [
                    "class" => Matiere::class,
                    "choice_label" => "nom",
                    "multiple" => true, // avec ManyToMany obligatoirement ajouter multiple true
                    //"expanded" => true // les checkbox
                    "attr" => [
                        "class" => "select2"
                    ]
                ])
                
                ->add('stock', IntegerType::class , [

                    "label" => "Stock du produit",
                    "required" => false,
                ])
                // ->add('Ajouter', SubmitType::class )
            ;
        }



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'ajouter' => false,
            'modifier' => false
        ]);
    }
}
