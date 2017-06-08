<?php

namespace FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact_name', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control hint',
                ),
                'required' => true,
            ))
            ->add('contact_email', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control hint',
                ),
                'required' => true,
            ))
            ->add('contact_phone', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control hint',
                ),
                'required' => true,
            ))
            ->add('contact_note', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control hint',
                    'rows'  => 5,
                    'cols'  => 75,
                ),
                'required' => true,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }
}