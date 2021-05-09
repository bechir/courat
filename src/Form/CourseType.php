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
use App\Entity\Course;
use App\Entity\Subject;
use App\Entity\VideoSource;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('source', EntityType::class, [
                'class' => VideoSource::class,
                'choice_label' => 'name',
                'translation_domain' => false,
            ])
            ->add('publishedAt', TextType::class)
            ->add('startTime', TextType::class, ['required' => false])
            ->add('class', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'code',
                'choice_translation_domain' => 'messages',
            ])
            //attr_translation_parameters
            ->add('subject', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'code',
                'translation_domain' => true,
                'choice_translation_domain' => 'messages',
            ]);

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
