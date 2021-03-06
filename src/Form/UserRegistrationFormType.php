<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('firstName', TextType::class,[
                'label' => 'Firstname *',
                'empty_data' => '',
                'attr' => [
                            'placeholder' => 'Firstname (min 2 letters)'
                            ],
                'translation_domain' => 'messages',
            ])
            ->add('lastName',TextType::class,[
                'label' => 'Lastname *',
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Lastname (min 2 letters)'
                ],
                'translation_domain' => 'messages',
                /*'constraints' => [
                    new Regex([
                        'pattern' =>'/^([^0-9]*)$/',
                        'message' => 'Your name cannot contain a number ❌'
                    ]),
                ]*/
            ])
            ->add('email',EmailType ::class, [
                'label' => 'Email *',
                'help' => 'We never share your email',
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Email'
                ],
                'translation_domain' => 'messages'
            ])
            // don't use password: avoid EVER setting that on a
            // field that might be persisted
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => ['attr' => ['placeholder' => 'Password', 'class' => 'input-group-addon ml-auto inputPassword' ],
                    'label' => 'Password',
                    /*'help' => 'Minimum 8 and maximum 13 characters, at least one lowercase letter, one uppercase letter,
                     one numeric digit, and one special character, but cannot contain whitespace.',*/
                ],
                'second_options' => ['attr' => ['placeholder' => 'Repeat password', 'class' => 'input-group-addon ml-auto inputPassword' ],
                    'label' => 'Repeat password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Password is required ❌'
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 13,
                        'minMessage' => 'Come on, you can think of a longer password ❌',
                        'maxMessage' => 'Maximum Password length is limited to 13'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,13}$/',
                        'message' => 'This is not a valid Password ❌'
                    ]),
                ],
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
