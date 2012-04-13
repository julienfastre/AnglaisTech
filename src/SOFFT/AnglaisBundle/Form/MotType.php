<?php

namespace SOFFT\AnglaisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MotType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
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
            
        ;
    }

    public function getName()
    {
        return 'sofft_anglaisbundle_mottype';
    }
}
