<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $year = \date('Y');
        $minYear = $year-100;
        $builder
            ->add('firstName',TextType::class,[
                'label' => 'Firstname *',
                'attr' =>[
                    'placeholder' => 'Firstname (at least 2 characters)'
                    ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2]),
                ],
            ])
            ->add('Lastname',TextType::class,[
                'label' => 'lastName *',
                'attr' =>[
                    'placeholder' => 'Lastname (at least 2 characters)'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'help' => 'we never share your email',
                'attr' =>[
                    'placeholder' => 'Email'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ]
            ])
            ->add('dateOfBirth', DateType::class, [
                'widget' =>'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
                'years' => range($minYear, $year),
            ])
            ->add('gender', ChoiceType::class,[
                'label' => 'Gender *',
                'choices'  => [
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Third gender' =>'Third gender'],
                'placeholder' => 'Choose your gender',
                'constraints' => [
                    new NotBlank(),
                ]

            ])
            ->add('message', TextareaType::class,[
                'label' => 'Message *',
                'attr' =>[
                    'rows' => '4'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min'=>6])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
