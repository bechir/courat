<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('videoUrl')
            ->add('publishedAt', TextType::class)
            ->add('startTime', TextType::class, ['required' => false]);

        $builder->get('publishedAt')->addModelTransformer(new CallbackTransformer(
            function ($publishedAsDate) {
                return $publishedAsDate ? $publishedAsDate->format('d/m/Y H:i') : '';
            },

            function ($publishedAsString) {
                if (empty($publishedAsString)) {
                    return null;
                }

                return \DateTime::createFromFormat('d/m/Y H:i', $publishedAsString);
            }
        ));

        $builder->get('startTime')->addModelTransformer(new CallbackTransformer(
            function ($startTimeDate) {
                return $startTimeDate ? $startTimeDate->format('H:i') : '';
            },

            function ($startTimeString) {
                if (empty($startTimeString)) {
                    return null;
                }

                return \DateTime::createFromFormat('H:i', $startTimeString);
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
