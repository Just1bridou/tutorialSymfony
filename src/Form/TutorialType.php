<?php

namespace App\Form;

use App\Entity\Tutorial;
use App\Entity\Category;
use App\Form\QuestionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Twig\Extra\Markdown\MarkdownExtension;


class TutorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control',
                        'placeholder'=> 'Title'],
        ])
        ->add('content', TextareaType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control'],
        ])
        ->add('isPublished', ChoiceType::class, [
            'label' => 'Le publier maintenant ?',
            'choices'  => [
                'Oui' => true,
                'Non' => false,
            ],
            'expanded' => true,
            'attr' => ['class' => 'form-check form-control'],
        ])
        ->add('category', EntityType::class, [
            'label' => 'Catégorie : ',
            'class' => Category::class,
            'choice_label' => function (Category $category) {
                return $category->getContent();
            },
            'attr' => ['class' => 'form-control'],
        ])
        ->add('questions', CollectionType::class, [
            'entry_type' => QuestionType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Enregistrer',
            'attr' => ['class' => 'btn btn-primary'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tutorial::class,
        ]);
    }
}
