<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre del Cliente',
                'attr' => ['placeholder' => 'Ej: Juan Pérez']
            ])
            ->add('cif', TextType::class, [
                'label' => 'CIF',
                'attr' => ['placeholder' => 'Ej: B12345678']
            ])
            ->add('address', TextType::class, [
                'label' => 'Dirección',
                'attr' => ['placeholder' => 'Ej: C/ Falsa, 123']
            ])
            ->add('postal', TextType::class, [
                'label' => 'Código Postal',
                'attr' => ['placeholder' => 'Ej: 28001']
            ])
            ->add('location', TextType::class, [
                'label' => 'Localidad',
                'attr' => ['placeholder' => 'Ej: Madrid']
            ])
            ->add('country', TextType::class, [
                'label' => 'País',
                'attr' => ['placeholder' => 'Ej: España']
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Notas',
                'attr' => ['placeholder' => 'Escribe aquí algunas notas sobre el cliente...'],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}