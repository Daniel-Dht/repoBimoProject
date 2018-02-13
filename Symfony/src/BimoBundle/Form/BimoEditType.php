<?php

namespace BimoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use BimoBundle\Form\MedProtoType;
use BimoBundle\Form\PatientType;
use BimoBundle\Entity\MedProto;
use BimoBundle\Entity\Patient;



class BimoEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('urgency',  CheckboxType::class, array('required' => false))
            //->add('date',      DateTimeType::class)
            ->add('patient',   EntityType::class, array(
              'class'    => 'BimoBundle:Patient',
              'choice_label' => 'nom',
              'multiple' => false
            ))
            //->add('user');          
          //   ->add('medProtos', EntityType::class, array(
          //   'class'        => 'BimoBundle:MedProto',
          //   'choice_label' => 'nom',
          //   'multiple'     => true,
          //   'expanded'     => true,
          // ))
            ->add('medProtos', CollectionType::class, array(
            'entry_type'   => MedProtoType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false
            ))

            ->add('save',      SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BimoBundle\Entity\Bimo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bimobundle_bimo';
    }


}
