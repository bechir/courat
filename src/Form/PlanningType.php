<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('subjects', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'code',
                'translation_domain' => false,
                'choice_translation_domain' => 'messages',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Matière',
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
