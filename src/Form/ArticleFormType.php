<?php

namespace App\Form;

use App\Entity\Article;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
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
                    'placeholder' => 'Content of new article'
                ]
            ])
            ->add('publishedAt', null, [
                'widget' => 'single_text',
                /*'html5' => false,
                'attr' => [
                    'placeholder' => date('d/m/y H:i:s'),
                ],
                'format' => 'd/m/Y H:i:s',
                'date_format' => 'd/m/Y H:i:s',
                'translation_domain' => 'Default',
                'required' => false,*/
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
        ]);
    }
}
