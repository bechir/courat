<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Day;
use App\Entity\Planning;
use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classes', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'code',
                'choice_translation_domain' => 'messages',
            ])
            //attr_translation_parameters
            ->add('subjects', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'code',
                'translation_domain' => true,
                'choice_translation_domain' => 'messages',
            ])
            ->add('day', EntityType::class, [
                'class' => Day::class,
                'choice_label' => 'name',
                'translation_domain' => true,
                'choice_translation_domain' => 'messages',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
