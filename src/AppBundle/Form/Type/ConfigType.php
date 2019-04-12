<?php
/**
 * Created by PhpStorm.
 * User: Equipo
 * Date: 30/10/2017
 * Time: 9:32
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Configuracion'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('curso', TextType::class, array('label' => 'Curso: ', 'attr' => (array('class' => 'form-control', 'disabled' => 'disabled'))))
            ->add('horasMin', IntegerType::class, array('label' => 'Horas Minimas: ', 'attr' => (array('class' => 'form-control', 'disabled' => 'disabled'))))
            ->add('horasMax', IntegerType::class, array('label' => 'Horas Maximas: ', 'attr' => (array('class' => 'form-control', 'disabled' => 'disabled'))));

    }

}