<?php

namespace App\Form;

use App\Entity\Hilo;
use App\Entity\Tareas;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HiloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Título del hilo'],
            ])
            ->add('fechaCreacion', DateType::class, [
                'label' => 'Fecha de Creación',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('notas', TextareaType::class, [
                'label' => 'Notas',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Notas adicionales'],
            ])
            ->add('usuario', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Usuario',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('tarea', EntityType::class, [
                'class' => Tareas::class,
                'choice_label' => 'titulo',
                'label' => 'Tarea',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('dateMod', DateType::class, [
                'label' => 'Fecha de Modificación',
                'widget' => 'single_text',
                'html5' => true,
                'disabled' => true,
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hilo::class,
        ]);
    }
}