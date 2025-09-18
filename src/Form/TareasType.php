<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Estados;
use App\Entity\Tareas;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TareasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Título de la tarea'],
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Describe la tarea en detalle'],
            ])
            ->add('fecha_limite', DateType::class, [
                'label' => 'Fecha Límite',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('notas', TextareaType::class, [
                'label' => 'Notas',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Notas adicionales'],
            ])
            ->add('estado', EntityType::class, [
                'class' => Estados::class,
                'choice_label' => 'estado', // <-- CORREGIDO: Usamos 'estado'
                'label' => 'Estado',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('cliente', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'nombre', // <-- CORREGIDO: Usamos 'nombre'
                'label' => 'Cliente',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('usuario', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', // Este ya estaba correcto
                'label' => 'Usuario',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('dateAdd', DateType::class, [
                'label' => 'Fecha de Creación',
                'widget' => 'single_text',
                'html5' => true,
                'disabled' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dateEdit', DateType::class, [
                'label' => 'Fecha de Edición',
                'widget' => 'single_text',
                'html5' => true,
                'disabled' => true,
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tareas::class,
        ]);
    }
}