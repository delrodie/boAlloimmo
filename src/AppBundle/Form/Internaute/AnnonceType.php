<?php

namespace AppBundle\Form\Internaute;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->user = $options['user'];
        $user = $this->user;
        
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
                    'class' => 'form-control',
                    'placeholder' => 'Description du bien'
                ],
                'required' => true
            ])
            //->add('resume')
            ->add('prix', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'placeholder' => 'le montant du bien'
                ],
                'required' => false
            ])
            //->add('localisation', TextType::class)
            ->add('disponibilite', CheckboxType::class, [
                'required' => false,
            ])
            ->add('promotion', CheckboxType::class,['required'=>false])
            //->add('tags', TextType::class)
            //->add('typebienslug')
            ->add('affichagePrix', CheckboxType::class, [
                'required' => false,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'label' => '.'
            ])
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('typebien', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Selectionnez le type de bien'
                ],
                'required' => true,
                'class' => 'AppBundle:Typebien',
                'query_builder' =>  function(EntityRepository $er){
                    return $er->getList();
                },
                'choice_label'  => 'libelle',
            ])
            ->add('zone', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Selectionnez la zone'
                ],
                'required' => true
            ])
            ->add('mode', null , [
                'attr' => [
                    'class' => 'form-control',
                    'plceholder' => 'Selectionnez le mode'
                ],
                'required' => true,
            ])
            ->add('utilisateur', EntityType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'hidden' => true,
                ),
                'class' => 'AppBundle:Utilisateur',
                'query_builder' =>  function(EntityRepository $er) use($user){
                    return $er->findUtilisateur($user);
                },
                'choice_label'  => 'nom',
            )
        )
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AnnonceBien',
            'user' => null
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
