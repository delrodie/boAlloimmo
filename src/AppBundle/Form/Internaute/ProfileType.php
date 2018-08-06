<?php

namespace AppBundle\Form\Internaute;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->user = $options['user'];
        $user = $this->user;

        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'autocompletd' => 'off',
                    'placeholder' => 'Nom et prenoms ou raison sociale *'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'autocompletd' => 'off',
                    'placeholder' => 'Adresse geographique *'
                ]
            ])
            ->add('website', TextType::class, [
                'attr'=> [
                    'class' => 'form-control',
                    'autocompletd' => 'off',
                    'placeholder' => 'Site internet'
                ],
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'attr'=> [
                    'class' => 'form-control',
                    'autocompletd' => 'off',
                    'placeholder' => 'Contact telephonique *'
                ],
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'attr'=> [
                    'class' => 'form-control',
                    'placeholder' => 'Description *'
                ],
                'required' => true
            ])
            ->add('type', ChoiceType::class,[
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices'=>[
                    '-- Selectionnez votre statut --' => '',
                    'PARTICULIER' => 'Particulier',
                    'ENTREPRISE'=> 'Entreprise'
                ]
            ])
            //->add('statut', CheckboxType::class)
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'label' => 'Telecharger votre logo',
            ])
            ->add('user', EntityType::class, array(
                    'attr'  => array(
                        'class' => 'form-control',
                        'autocomplete'  => 'off',
                        'hidden' => true,
                    ),
                    'class' => 'AppBundle:User',
                    'query_builder' =>  function(EntityRepository $er) use($user){
                        return $er->findUser($user);
                    },
                    'choice_label'  => 'username',
                )
            )
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur',
            'user'  => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_utilisateur';
    }


}
