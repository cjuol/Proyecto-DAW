<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class resetPasswordType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Form\Model\resetPassword'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => array(
                    'label' => 'Contraseña: ',
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Introduzca su contraseña')),
                'second_options' => array(
                    'label' => 'Repite la Contraseña: ',
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Repita su contraseña')),
            ));
    }

}