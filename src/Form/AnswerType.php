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
<<<<<<< HEAD
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'Réponse'],
=======
                'label' => 'form.answer.answer',
                'attr' => ['class' => 'form-control'],
>>>>>>> 5152334e574c5641f7c799e90f8e0d08856349cf
            ])
            ->add('isCorrect', ChoiceType::class, [
                'label' => 'form.answer.is_correct',
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
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
