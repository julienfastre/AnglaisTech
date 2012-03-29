<?php

namespace SOFFT\AnglaisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MotType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fr')
            ->add('en')
            ->add('explication')
            
        ;
    }

    public function getName()
    {
        return 'sofft_anglaisbundle_mottype';
    }
}
