<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceVillaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('piece')->add('douche')->add('toilette')->add('dressing')->add('terasse')->add('superficie')->add('cuisine')->add('garage')->add('piscine')->add('parking')->add('chauffeau')->add('videosurveillance')->add('alarme')->add('buanderie')->add('interphone')->add('meuble')->add('annoncebien');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AnnonceVilla'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_annoncevilla';
    }


}
