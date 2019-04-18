<?php

namespace BlogBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreArticle')
                ->add('blog')
                ->add('image', FileType::class, array('data_class' => null))

            ->add('blog', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',)))

                ->add('tags',TagType::class)
                ->add('Categorie',EntityType::class,array(
                    'class'=>'BlogBundle\Entity\Categorie',
                    'choice_label'=>'categorie',
                    'expanded'=>false,
                    'multiple'=>false,
                ))

                ->add('ajouter',SubmitType::class)
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blogbundle_article';
    }


}
