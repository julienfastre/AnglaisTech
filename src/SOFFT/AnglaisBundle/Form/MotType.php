<?php

namespace SOFFT\AnglaisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fr', 'textarea', array(
                'required' => false
            ))
            ->add('en', 'textarea', array(
                'required' => false
            ))
            ->add('explication', 'textarea', array(
                'required' => false
            ))
            ->add('tags', 'entity', array(
                'class' => 'SOFFTAnglaisBundle:Tag',
                'multiple' => true,
                'expanded' => true
            ))
            
        ;
    }

    public function getName()
    {
        return 'sofft_anglaisbundle_mottype';
    }
}
