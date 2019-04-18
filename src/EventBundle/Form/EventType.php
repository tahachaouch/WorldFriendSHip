<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nbrplaceEvent')
            ->add('typeEvent' , choiceType::class,array('choices'=>array(
                'Event Type'=>'Event Type',
                'Événement sportif'=>'Événement sportif',
                'Congrès'=>'Congrès',
                'Festival et défilé'=>'Festival et défilé',
                'tournée promotionnels'=>'tournée promotionnels',
                'Camping'=>'Camping',
                )))
            ->add('title_event')
            ->add('description_Event')
            ->add('startdateevent',DateTimeType::class)
            ->add('enddateevent',DateTimeType::class)
            ->add('image_Event', FileType::class, array('data_class' => null))
            ->add('adresse_Event')
            ->add('type_hebergement', choiceType::class,array('choices'=>array(
                    'type hebergement'=>'type hebergement',
                    'auberges et B&B'=>'auberges et B&B',
                    'Chambres d’hôtes'=>'Chambres d’hôtes',
                    'Camping'=>'Camping',
                    'Échange de maisons'=>'Échange de maisons',
                    'Co-living'=>'Co-living',

                )
            ))
            ->add('adressehebergement')
        ->add('Add', submitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventbundle_event';
    }


}
