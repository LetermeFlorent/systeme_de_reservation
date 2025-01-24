<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date de l\'activité',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('heure', TimeType::class, [
                'label' => 'Heure de l\'activité',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('duration_hours', IntegerType::class, [
                'label' => 'Heures',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'max' => 23,
                ],
            ])
            ->add('duration_minutes', IntegerType::class, [
                'label' => 'Minutes',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'max' => 59,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}