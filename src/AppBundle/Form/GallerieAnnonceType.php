<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GallerieAnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->bien = $options['annonce'];
        $bien = $this->bien;

        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => true,
                'allow_delete' => true,
                'label' => '.',
            ])
            //->add('imageSize')->add('updatedAt')
            ->add('annonce', EntityType::class, array(
                    'attr'  => array(
                        'class' => 'form-control',
                        'autocomplete'  => 'off'
                    ),
                    'class' => 'AppBundle:AnnonceBien',
                    'query_builder' =>  function(EntityRepository $er) use($bien){
                        return $er->findBien($bien);
                    },
                    'choice_label'  => 'titre',
                )
            )
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\GallerieAnnonce',
            'annonce'  => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_gallerieannonce';
    }


}
