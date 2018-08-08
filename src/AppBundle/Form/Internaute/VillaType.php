<?php

namespace AppBundle\Form\Internaute;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class VillaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->bien = $options['bien'];
        $bien = $this->bien;
        
        $builder
            ->add('piece', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de pieces',
                    'autocomplete' => 'off'
                ],
                'required' => true,
            ])
            ->add('douche', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de douches',
                    'autocomplete' => 'off'
                ],
                'required' => true,
            ])
            ->add('toilette', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de toilettes',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('dressing', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('terasse', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('superficie', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'La superficie de la villa',
                    'autocomplete' => 'off'
                ], 
                'required' => false,
            ])
            ->add('cuisine', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Superficie de la cuisine',
                    'autocomplete' => 'off'
                ],
                'required' => false,
            ])
            ->add('garage', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('piscine', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('parking', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'hidden' => true,
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('chauffeau', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('videosurveillance', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('alarme', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('buanderie', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('interphone', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('meuble', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('annoncebien', EntityType::class, array(
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
            'data_class' => 'AppBundle\Entity\AnnonceVilla',
            'bien' => null
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
