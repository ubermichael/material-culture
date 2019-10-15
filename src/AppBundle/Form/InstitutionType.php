<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * InstitutionType form.
 */
class InstitutionType extends AbstractType
{
    /**
     * Add form fields to $builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        $builder->add('name', null, array(
            'label' => 'Name',
            'required' => true,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('url', null, array(
            'label' => 'Url',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('address', null, array(
            'label' => 'Address',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('contact', null, array(
            'label' => 'Contact',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        
    }
    
    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Institution'
        ));
    }

}
