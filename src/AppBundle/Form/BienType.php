<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BienType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Titre du bien'
                )
            ))
            ->add('description', TextareaType::class)
            ->add('prix', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Le montant du bien'
                )
            ))
            ->add('localisation', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Localisation du bien'
                )
            ))
            ->add('disponibilite', CheckboxType::class, array(
                'attr'  => array(
                    'class' => 'custom-control-input'
                ),
                'required' => false,
            ))
            ->add('tags', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control tag-input',
                    'autocomplete'  => 'off',
                    'data-role' => "tagsinput",
                    'placeholder'   => 'Mots clés'
                )
            ))
            ->add('datedebut', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control dpd1',
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
            ->add('promotion', CheckboxType::class, array(
                'attr'  => array(
                    'class' => 'custom-control-input'
                ),
                'required' => false,
            ))
            ->add('affichagePrix', CheckboxType::class, array(
                'attr'  => array(
                    'class' => 'custom-control-input'
                ),
                'required' => false,
            ))
            ->add('typebien', null, array(
                'attr' => array(
                    'class' => 'form-control select-typebien',
                    'placeholder'   => 'Le type de bien'
                )
            ))
            ->add('mode', null, array(
                'attr' => array(
                    'class' => 'form-control select-typebien',
                    'placeholder'   => 'Mode de mise en ligne'
                )
            ))
            ->add('zone', null, array(
                'attr' => array(
                    'class' => 'form-control select-zone',
                    'placeholder'   => 'La zone de localisation'
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
            //->add('imageName')->add('imageSize')->add('updatedAt')
            //->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Bien'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_bien';
    }


}
