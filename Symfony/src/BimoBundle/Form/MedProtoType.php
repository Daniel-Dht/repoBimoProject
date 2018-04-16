<?php

namespace BimoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class MedProtoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomBefore',      TextType::class, array(
                'label'=>'Médicament',
                'attr' => array(
                'placeholder' => 'saisissez un medicament'
            )))
            ->add('dosageBefore',   TextType::class, array(
                'label'=>'Dosage'))
            ->add('formBefore',     TextType::class)
            ->add('poseBefore',     TextType::class, array(
                'attr' => array(
                'placeholder' => ' ex: 101 ou 1-0-1'
            )))
            ->add('nom',            TextType::class, array(
                'label'=>'Médicament',
                'attr' => array(
                'placeholder' => 'saisissez un medicament'
            )))
            ->add('dosage',         TextType::class)
            ->add('forme',          TextType::class)
            ->add('poso',           TextType::class, array(
                'attr' => array(
                'placeholder' => ' ex: 101 ou 1-0-1'
            )))
            ->add('divergence',     TextType::class)
            ->add('source',         TextType::class)
            ->add('divergenceType', TextType::class)
            ->add('severity',       TextType::class)
            
            ->add('proposition',    TextareaType::class)
            ->add('comment',        TextareaType::class)           

            ->add('medStartBefore', DateType::class)
            ->add('medEndBefore',   DateType::class)
            ->add('dateMedBefore',  CheckboxType::class, array('required' => false, 'label'=>'Ne pas mentionner les dates'))

            ->add('medStartHosp',   DateType::class)
            ->add('medEndHosp',     DateType::class)
            ->add('dateMedHosp',    CheckboxType::class, array('required' => false, 'label'=>'Ne pas mentionner les dates'))

            ->add('save',           SubmitType::class, array(
                'label'=>'Enregistrer',
            ))
        ;
    }

    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BimoBundle\Entity\MedProto'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bimobundle_medproto';
    }


}
