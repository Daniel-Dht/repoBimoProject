<?php

namespace BimoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PatientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',      TextType::class, array(
                'label'=>'Nom',
                'attr' => array(
                'placeholder' => 'BLANCO'
            )))
            ->add('prenom',   TextType::class, array(
                'label'=>'Prénom',
                'attr' => array(
                'placeholder' => 'Eric'
            )))
            ->add('birthDay',   TextType::class, array(
                'required' => false,
                'attr' => array(
                'placeholder' => '25/07/1987'
            )))
            ->add('adress',   TextType::class, array(
                'required' => false,
                'attr' => array(
                'placeholder' => ' '
            )))
            ->add('phoneNumber',   TextType::class, array(
                'required' => false,
                'attr' => array(
                'placeholder' => '06 44 10 32 41'
            )))
            ->add('socialSecurityNumber',   TextType::class, array(
                'required' => false,
                'attr' => array(
                'placeholder' => '00645489131'
            )))
            ->add('mail',   TextType::class, array(
                'required' => false,
                'attr' => array(
                'placeholder' => ''
            )))
            ->add('doctor',   TextType::class, array(
                'required' => false,
                'attr' => array(
                'placeholder' => ''
            )))
            ->add('bloodGroup',   TextType::class, array(
                'required' => false,
                'attr' => array(
                'placeholder' => ''
            )))
            ->add('save',     SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BimoBundle\Entity\Patient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bimobundle_patient';
    }


}
