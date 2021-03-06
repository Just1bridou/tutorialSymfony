<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'form.answer.answer'],
            ])
            ->add('isCorrect', ChoiceType::class, [
                'label' => 'form.js_answer.correct_answer',
                'choices'  => [
                    'form.js_answer.yes' => true,
                    'form.js_answer.no' => false,
                ],
                'expanded' => true,
                'attr' => ['class' => 'form-check form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
