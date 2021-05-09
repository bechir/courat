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
use App\Entity\Document;
use App\Entity\DocumentCategory;
use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('file', FileType::class)
            ->add('subject', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'code',
                'choice_translation_domain' => 'messages',
            ])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => function (Classe $classe) {
                    return 'class.' . $classe->getName();
                },
                'choice_translation_domain' => 'messages',
            ])
            ->add('category', EntityType::class, [
                'class' => DocumentCategory::class,
                'choice_label' => 'name',
                'choice_translation_domain' => 'messages',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
