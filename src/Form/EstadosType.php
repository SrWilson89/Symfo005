<?php

namespace App\Form;

use App\Entity\Estados;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstadosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('estado', TextType::class, [
                'label' => 'Estado',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ej. Activo, Pendiente, Finalizado'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estados::class,
        ]);
    }
}