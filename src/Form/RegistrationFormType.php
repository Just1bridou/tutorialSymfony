<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                            'placeholder'=> 'form.register.username'],
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'label' => 'Accepter les terms d\'utilisation',
            //     'attr' => ['class' => 'form-control'],
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder'=> 'form.register.password'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'form.register.password_not_blank',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder'=> 'form.register.email'],
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder'=> 'form.register.city'],
            ])
            ->add('zip', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder'=> 'form.register.zip'],
            ])
            ->add('address', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder'=> 'form.register.address'],
            ])
            ->add('birthday', DateType::class, [
                'label' => 'form.register.birthdate',
                'attr' => ['class' => 'form-control'],
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100),
                'months' => range(1, 12),
                'days' => range(1, 31),
                'placeholder' => [
                    'year' => 'form.register.year', 'month' => 'form.register.month', 'day' => 'form.register.day',
                ],
                'format' => 'dd MM yyyy',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'form.register.save',
                'attr' => ['class' => 'btn btn-primary submitButton'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
