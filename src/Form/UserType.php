<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Introduce el correo electrónico'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Introduce la contraseña'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => [
                    'Usuario' => 'ROLE_USER',
                    'Administrador' => 'ROLE_ADMIN'
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-check'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}