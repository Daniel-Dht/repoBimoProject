<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class UserEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',    TextType::class)
            ->add('password',    TextType::class)
            // ->add('roles', CollectionType::class, array(
            //     'label'=>'Choix des droits',
            //     'entry_type' => ChoiceType::class,
            //     'entry_options'  => array(
            //         'choices'  => array(
            //             'simple utilsateur' => 'ROLE_USER',
            //             'Adminsitrateur' => 'ROLE_ADMIN',
            //             'Administrateur Superieur' => 'ROLE_SUPER_ADMIN',
            //         ),
            //     ),    
            //)) 
            ->add('roles', ChoiceType::class, array(
                'attr'  =>  array('class' => 'form-control',
                    'style' => 'margin:5px 0;'),
                'choices' =>
                    array
                    (
                        'simple utilsateur' => 'ROLE_USER',
                        'Adminsitrateur' => 'ROLE_ADMIN',
                        'Administrateur Superieur' => 'ROLE_SUPER_ADMIN',
                    ) ,
                'multiple' => true,
                'required' => true,
            ))  
            
            ->add('save',           SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_user';
    }


}
