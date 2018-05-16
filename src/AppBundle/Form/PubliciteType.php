<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PubliciteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datedebut', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control dpd2',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'La date debut de publicité'
                ),
                'required' => false,
            ))
            ->add('datefin', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control dpd2',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'La date fin de publicité'
                ),
                'required' => false,
            ))
            ->add('statut', CheckboxType::class, array(
                'attr'  => array(
                    'class' => 'custom-control-input'
                ),
                'required' => false,
            ))
            ->add('titre', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Titre de la publicité'
                )
            ))
            ->add('partenaire', null, array(
                'attr' => array(
                    'class' => 'form-control select-partenaire',
                )
            ))
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'label' => '.',
            ])
            //->add('updatedAt')
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Publicite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_publicite';
    }


}
