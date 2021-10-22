<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['inscription'])
        {
            $builder
                ->add('email', TextType::class, [
                    "required" => false
                ])

                // ->add('password', RepeatedType::class, [
                //     "required" => false,
                //     "label" => "Mot de passe",
                //     "constraints" => [
                //         new NotBlank([
                //             'message' => "Veuillez saisir un mot de passe",
                //         ]),
                //         new EqualTo([
                //             "propertyPath" => "confirmPassword",
                //             "message" => "Les mots de passe ne sont pas identiques"
                //         ])
                //     ]
                // ])

                // ->add('confirmPassword', TextType::class, [
                //     "required" => false,
                //     "label" => "Confirmation du mot de passe",
                //     "constraints" => [
                //         new NotBlank([
                //             'message' => "Veuillez confirmer le mot de passe",
                //         ])
                //     ]
                // ])

                  ->add('password', RepeatedType::class, [
                    "required" => false,
                   
                    "type" => TextType::class,
                    "first_name" => "first",
                    "second_name" => "second",
                    "invalid_message" => "Les mots de passe ne sont pas identiques",
                    "first_options" => [
                        'label' => "Mot de passe"
                    ],
                    "second_options" => [
                        'label' => "Confirmation du mot de passe"
                    ],

                    "constraints" => [
                        new NotBlank([
                            'message' => "Veuillez saisir un mot de passe",
                        ]),
                    ]
                ])

                ->add('nom', TextType::class, [
                    "required" => false,
                ])

                ->add('prenom', TextType::class, [
                    "required" => false,
                    "label" => "Prénom"
                ])
            ;
        }
        elseif($options['profil'])
        {
            $builder
                ->add('email', TextType::class, [
                    "required" => false
                ])

                ->add('nom', TextType::class, [
                    "required" => false
                ])

                ->add('prenom', TextType::class, [
                    "required" => false,
                    "label" => "Prénom"
                ])
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'inscription' => false,
            'profil' => false

        ]);
    }
}
