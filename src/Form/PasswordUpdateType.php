<?php

namespace App\Form;

use App\Entity\PasswordUpdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PasswordUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', TextType::class, [
                "required" => false,
                "label" => "Ancien mot de passe"
            ])
            ->add('newPassword', TextType::class, [
                "required" => false,
                "label" => "Nouveau mot de passe"
            ])
            ->add('confirmPassword', TextType::class, [
                "required" => false,
                "label" => "Confirmation nouveau mot de passe"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => PasswordUpdate::class
        ]);
    }
}
