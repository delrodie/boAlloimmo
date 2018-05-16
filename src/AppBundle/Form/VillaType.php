<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('piece', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Nombre de pièces'
                )
            ))
            ->add('douche', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Nombre de douche'
                )
            ))
            ->add('toilette', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Nombre de salles d\'eau'
                )
            ))
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
            ->add('superficie', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Superficie de la villa'
                )
            ))
            ->add('cuisine', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Superficie de la cuisine'
                )
            ))
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
            ->add('bien', EntityType::class, array(
                    'attr'  => array(
                        'class' => 'form-control',
                        'autocomplete'  => 'off'
                    ),
                    'class' => 'AppBundle:Bien',
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
            'data_class' => 'AppBundle\Entity\Villa',
            'bien'  => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_villa';
    }


}
