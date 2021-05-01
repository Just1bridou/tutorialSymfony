<?php

namespace App\Form;

use App\Entity\Question;
use App\Form\AnswerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', NumberType::class, [
<<<<<<< HEAD
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'Position'],
            ])
            ->add('content', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'Question'],
=======
                'label' => 'form.question.position',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('content', TextType::class, [
                'label' => 'form.question.question',
                'attr' => ['class' => 'form-control'],
>>>>>>> 5152334e574c5641f7c799e90f8e0d08856349cf
            ])
            ->add('answers', CollectionType::class, [
                'label' => false,
                'entry_type' => AnswerType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
