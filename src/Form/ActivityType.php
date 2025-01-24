<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Level;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', null, [
                'label' => 'Titre',
            ])
            ->add('description', null, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'choice_label' => 'label',
                'label' => 'Niveau de difficulté',
                'placeholder' => 'Choisir un niveau',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de l\'activité',
                'mapped' => false, // Ne pas mapper ce champ à l'entité
                'widget' => 'single_text', // Afficher un calendrier
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('heure', TimeType::class, [
                'label' => 'Heure de l\'activité',
                'mapped' => false, // Ne pas mapper ce champ à l'entité
                'widget' => 'single_text', // Afficher un sélecteur d'heure
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('duration_hours', IntegerType::class, [
                'label' => 'Heures',
                'mapped' => false, // Ne pas mapper ce champ à l'entité
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0, // Heures minimales
                    'max' => 23, // Heures maximales
                ],
            ])
            ->add('duration_minutes', IntegerType::class, [
                'label' => 'Minutes',
                'mapped' => false, // Ne pas mapper ce champ à l'entité
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0, // Minutes minimales
                    'max' => 59, // Minutes maximales
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}