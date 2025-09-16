<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Estados;
use App\Entity\Tareas;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TareasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('notas')
            ->add('dateAdd')
            ->add('dateEdit')
            ->add('titulo')
            ->add('descripcion')
            ->add('fecha_limite')
            ->add('estado', EntityType::class, [
                'class' => Estados::class,
                'choice_label' => 'id',
            ])
            ->add('cliente', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'id',
            ])
            ->add('usuario', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tareas::class,
        ]);
    }
}
