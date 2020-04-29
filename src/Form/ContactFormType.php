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
use Symfony\Component\Validator\Constraints\Regex;

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
                    'placeholder' => 'Firstname (min 2 letters)'
                    ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Firstname is required ❌'
                    ]),
                    new Length(['min' => 2]),
                    new Regex(['pattern'=>"/\d/",'match'=>false, 'message'=>"Firstname cannot contain a number ❌"])
                ],
                'translation_domain' => 'messages'
            ])
            ->add('Lastname',TextType::class,[
                'label' => 'Lastname *',
                'attr' =>[
                    'placeholder' => 'Lastname (min 2 letters)'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Lastname is required ❌'
                    ]) ,
                    new Length(['min' => 2]),
                    new Regex(['pattern'=>"/\d/",'match'=>false, 'message'=>"Lastname cannot contain a number ❌"])
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'help' => 'We never share your email',
                'attr' =>[
                    'placeholder' => 'Email'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Email is required ❌'
                    ]),
                    new Email(),
                ]
            ])
            ->add('dateOfBirth', DateType::class, [
                'widget' =>'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
                'format' => 'dd/MM/yyyy',
            ])
            ->add('gender', ChoiceType::class,[
                'label' => 'Gender *',
                'choices'  => [
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Third gender' =>'Third gender'],
                'placeholder' => 'Choose your gender',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Gender is required ❌'
                    ]),
                ],
                'translation_domain' => 'messages'

            ])
            ->add('message', TextareaType::class,[
                'label' => 'Message *',
                'attr' =>[
                    'rows' => '4'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Message is required ❌'
                    ]),
                    new Length(['min'=>6, 'minMessage' => 'Message is too short. It should have 6 characters or more ❌'])
                ],
                'translation_domain' => 'messages'
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
