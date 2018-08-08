<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AnnonceBienType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'placeholder' => 'Titre du bien'
                ],
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'forn-control',
                    'placeholder' => 'Description du bien'
                ],
                'required' => true
            ])
            //->add('resume')
            ->add('prix', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'off'
                ],
                'required' => false
            ])
            ->add('localisation', TextType::class)
            ->add('disponibilite', CheckboxType::class)
            ->add('tags', TextType::class)
            ->add('typebienslug', null)
            ->add('affichagePrix', CheckboxType::class)
            ->add('imageName')
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('typebien')
            ->add('zone')
            ->add('mode')
            ->add('utilisateur')
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AnnonceBien'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_annoncebien';
    }


}
