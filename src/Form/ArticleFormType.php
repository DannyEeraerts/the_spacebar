<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Title *',
                'attr' => [
                    'placeholder' => 'Title of new article'
                ]
            ])
            ->add('content', null, [
                'label' => 'Content *',
                'attr' => [
                    'placeholder' => 'Content of new article',
                    'rows' => 6
                ]
            ])
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'datetimepicker',
                    'placeholder' => 'Select a date and time'],
                'format' => 'd/m/Y H:i:s',
                'date_format' => 'd/m/Y H:i:s',
            ])
            ->add('imageFileName', null,[
                'attr'=> [
                    'placeholder' => 'Image File name (.png or .jpg)'
                ]
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
