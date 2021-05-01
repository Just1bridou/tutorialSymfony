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
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'form.question.position'],
            ])
            ->add('content', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'form.question.question'],
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
