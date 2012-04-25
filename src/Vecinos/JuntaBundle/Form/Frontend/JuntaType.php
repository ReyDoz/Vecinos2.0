<?php

namespace Vecinos\JuntaBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Formulario para crear y manipular entidades de tipo Junta.
 * Como se utiliza en la extranet, algunas propiedades de la entidad
 * no se incluyen en el formulario.
 */
class JuntaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('descripcion', 'textarea', array(
            'attr' => array(
            'class' => 'tinymce',
            'data-theme' => 'medium' // simple, advanced, bbcode
            )
            ))
            ->add('lugar')
            ->add('fecha')
            ->add('hora1')
            ->add('hora2')
            //->add('usuarios', null, array('required' => false))
        ;
        
    }

    public function getName()
    {
        return 'nueva_junta';
    }
}