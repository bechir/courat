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

use Symfony\Component\Form\FormBuilderInterface;

class TeacherCourseType extends CourseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title')
            ->remove('videoUrl')
            ->remove('source')
            ->remove('publishedAt')
            ->remove('startTime');
    }
}
