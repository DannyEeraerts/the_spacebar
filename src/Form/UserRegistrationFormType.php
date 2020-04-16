<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null,[
                'label' => 'FirstName *',
                'attr' => [
                            'placeholder' => 'Firstname (min 2 letters)'
                            ],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Come on, you can think of a longer password ❌'
                    ])
                ]
            ])
            ->add('lastName',null,[
                'label' => 'LastName *',
                'attr' => [
                    'placeholder' => 'Lastname (min 2 letters)'
                ]
            ])
            ->add('email',EmailType ::class, [
                'label' => 'Email *',
                'help' => 'We never share your email',
                'attr' => [
                    'placeholder' => 'Email)'
                ]
            ])
            // don't use password: avoid EVER setting that on a
            // field that might be persisted
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' =>
                    [new  NotBlank([
                        'message' => 'Choose a password ❌'
                        ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Come on, you can think of a longer password ❌'
                        ])
                    ],
                'label' => 'Password *',
                'help' => 'Minimum 8 characters, at least one lowercase letter, one uppercase letter, one numeric digit, and one special character, but cannot contain whitespace.'
                ])
            ->add('agreeTerms', CheckboxType::class,[
                'mapped' => false,
                'constraints' =>
                    [new Istrue([
                        'message' => 'You must agree to our terms and privacy policy ❌'
                        ])
                    ],
                'label' => 'Agree terms and privacy policy'
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
