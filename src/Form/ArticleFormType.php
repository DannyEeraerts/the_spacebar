<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Article|null $article */
        $article = $options['data'] ?? null;
        $isEdit = $article && $article->getId();

        $builder
            ->add('title', null, [
                'label' => 'Title *',
                'attr' => [
                    'placeholder' => 'Title of new article'
                ]
            ])
            ->add('content', null, [
                'label' => 'Content (english) *',
                'attr' => [
                    'placeholder' => 'Content of new article (english)',
                    'rows' => 4
                ]
            ])
            ->add('contentNl', TextareaType::class, [
                'label' => 'Translated content (dutch) *',
                'attr' => [
                    'placeholder' => 'Translated content of new article (dutch)',
                    'rows' => 4
                ]
            ])
            ->add('publishedAt', DateTimeType::class, [
                'label' => 'Published at',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'datetimepicker',
                    'placeholder' => 'Select a date and time'],
                'format' => 'Y-mm-d H:i:s',
                'date_format' => 'Y-mm-d H:i:s',
            ]);

        $imageConstraints = [
                new Image([
                    'maxSize' => '32M',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/jpg',
                    ],
                    'mimeTypesMessage' => 'The file must be of format .jpg or .png or .jpeg ❌',
                    'maxSizeMessage' => 'Max FileSize must be lower than 32M ❌'
                ],)
            ];

        if (!$isEdit || !$article->getImageFilename()) {
            $imageConstraints[] = new NotNull([
                'message' => 'Please upload an image ❌',
            ]);
        }

        $builder
            ->add('imageFile', FileType::class,[
                'mapped' => false,
                'label' => 'Image-file',
                'required' => false,
                'constraints' => $imageConstraints
            ])
        ;
    }
    // bind form to Article class
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            /*'attr' => ['id' => 'datetimepicker']*/
        ]);
    }
}
