<?php

namespace App\Form;

use App\Entity\Achievement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchievementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('targetField', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                            'placeholder'=> 'form.achievement.target_field'],
            ])
            ->add('mathematicalOperator', null, [
                'label' => 'form.achievement.mathematical_operator',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('goal', NumberType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                            'placeholder'=> 'form.achievement.goal'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'form.achievement.save',
                'attr' => ['class' => 'btn btn-primary submitFormQuestions'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Achievement::class,
        ]);
    }
}
