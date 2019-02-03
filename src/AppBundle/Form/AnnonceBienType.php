<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
            ->add('localisation', TextType::class, ['attr'=> ['class'=> 'form-control'], 'required'=> false])
            ->add('disponibilite', CheckboxType::class, ['attr' => ['class' => 'custom-control-input'], 'required' => false])
            ->add('tags', TextType::class,[
                'attr' => [
                    'class' => 'form-control tag-input',
                    'data-role' => "tagsinput",
                ]
            ])
            ->add('statut', CheckboxType::class,['attr'=>['class'=>'custom-control-input'], 'required'=>false])
            ->add('affichagePrix', CheckboxType::class, ['attr' => ['class' => 'custom-control-input'], 'required' => false])
            ->add('imageFile', VichImageType::class,[
                'required' => false,
                'allow_delete' => true,
                'label' => '.'
            ])
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('typebien', null, ['attr'=>['class' => 'form-control']])
            ->add('zone', null, ['attr'=>['class' => 'form-control']])
            ->add('mode', null, ['attr'=>['class' => 'form-control']])
            ->add('utilisateur', null, ['attr'=>['class' => 'form-control']])
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
