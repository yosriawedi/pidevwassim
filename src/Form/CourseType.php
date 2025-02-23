<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Tutor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Description')
            
            // Domain as a choice list
            ->add('Domain', ChoiceType::class, [
                'choices' => [
                    'IT' => 'IT',
                    'Marketing' => 'Marketing',
                    'Management' => 'Management',
                    'Design' => 'Design',
                    'Data science' => 'Data science',
                    'Deep learning' => 'Deep learning',
                    'Excel' => 'Excel',
                    'Soft skills' => 'Soft skills',
                ],
                'expanded' => false,  // Use a select dropdown
                'multiple' => false,  // Single choice only
            ])

            // Type field remains a choice
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Paid' => 'paid',
                    'Free' => 'free',
                ],
                'expanded' => false,
                'multiple' => false,
            ])

            ->add('Price')
            ->add('CreationDate', null, [
                'widget' => 'single_text',
            ])
            
            ->add('tutor', EntityType::class, [
                'class' => Tutor::class,
                'choice_label' => 'id',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
