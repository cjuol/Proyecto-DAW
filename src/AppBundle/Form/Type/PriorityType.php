<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriorityType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Form\Model\Priority',
            'uPrioridad' => 0,
            'turno' => 0
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $uPr = $options['uPrioridad'];
        $turno = $options['turno'];
        $values = [];
        $values[0] = $uPr;
        for ($k = 1; $k < 6; $k++){
            $values[$k] = $values[$k-1] + $turno;
        }
        $builder
            ->add('prioridad', ChoiceType::class, array(
                'choices' => array(
                    1 => $values[0],
                    2 => $values[1],
                    3 => $values[2],
                    4 => $values[3],
                    5 => $values[4],
                    6 => $values[5],
                ),
                'attr' => (array(
                    'class' => 'form-control')),
                'label' => 'Seleccione prioridad'
            ));
    }

}