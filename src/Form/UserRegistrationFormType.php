<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

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
                /* 'constraints' => [
                   new Regex([
                        '/\d/',
                        'message' => 'Your name cannot contain a number ❌'
                    ]),
                ]*/
            ])
            ->add('lastName',null,[
                'label' => 'LastName *',
                'attr' => [
                    'placeholder' => 'Lastname (min 2 letters)'
                ],
                /*'constraints' => [
                    new Regex([
                        '/\d/',
                        'message' => 'Your name cannot contain a number ❌'
                    ]),
                ]*/
            ])
            ->add('email',EmailType ::class, [
                'label' => 'Email *',
                'help' => 'We never share your email',
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ])
            // don't use password: avoid EVER setting that on a
            // field that might be persisted
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => ['attr' => ['placeholder' => 'password', 'class' => 'input-group-addon ml-auto inputPassword' ],
                                    'label' => 'Password',
                                    /*'help' => 'Minimum 8 and maximum 13 characters, at least one lowercase letter, one uppercase letter,
                                     one numeric digit, and one special character, but cannot contain whitespace.',*/
                ],
                'second_options' => ['attr' => ['placeholder' => 'repeat password', 'class' => 'input-group-addon ml-auto inputPassword' ],
                                    'label' => 'Repeat password',
                ],
                'constraints' =>
                    [new NotBlank([
                        'message' => 'This is not a valid Password ❌'
                        ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Come on, you can think of a longer password ❌'
                        ]),
                    new Regex([
                        '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,13}$/',
                        'message' => 'This is not a valid Password ❌'
                    ]),
                    ],
                'invalid_message' => 'The password fields must match ❌',
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
