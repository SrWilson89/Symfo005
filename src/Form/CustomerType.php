<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('cif', TextType::class, [
                'label' => 'CIF',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('address', TextType::class, [
                'label' => 'Dirección',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('postal', TextType::class, [
                'label' => 'Código Postal',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('location', TextType::class, [
                'label' => 'Localidad',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('country', TextType::class, [
                'label' => 'País',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('notes', TextType::class, [
                'label' => 'Notas',
                'attr' => ['class' => 'form-control'],
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