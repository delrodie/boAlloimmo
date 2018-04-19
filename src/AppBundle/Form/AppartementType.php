<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppartementType extends AbstractType
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
            ->add('wc', IntegerType::class , array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Nombre de salles d\'eau'
                )
            ))
            ->add('douche', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Nombre de douche'
                )
            ))
            ->add('dressing', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Superficie en m2'
                )
            ))
            ->add('balcon', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Superficie en m2'
                )
            ))
            ->add('superficie', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'la superficie en m2'
                )
            ))
            ->add('cuisine', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'la superficie en m2'
                )
            ))
            ->add('etage', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'choices'   => array(
                    'OUI'   => 1,
                    'NON'   => null,
                ),
            ))
            ->add('netage', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Numero de l\'etage'
                ),
                'required'  => false,
            ))
            ->add('parking', IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'la superficie du parketing en m2'
                )
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
            ->add('ascenceur', ChoiceType::class, array(
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
            'data_class' => 'AppBundle\Entity\Appartement',
            'bien'  => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_appartement';
    }


}
