<?php

namespace App\Form;

use App\Entity\Hilo;
use App\Entity\tareas;
use App\Entity\user;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HiloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateAdd')
            ->add('dateMod')
            ->add('notas')
            ->add('usuario', EntityType::class, [
                'class' => user::class,
                'choice_label' => 'id',
            ])
            ->add('tarea', EntityType::class, [
                'class' => tareas::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hilo::class,
        ]);
    }
}
