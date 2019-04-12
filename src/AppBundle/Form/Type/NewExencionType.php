<?php
/**
 * Created by PhpStorm.
 * Usuario: Equipo
 * Date: 30/10/2017
 * Time: 9:32
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewExencionType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Exencion'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array('label' => 'Nombre: ', 'attr' => (array('class' => 'form-control'))))
            ->add('codigo', TextType::class, array('label' => 'Código: ', 'attr' => (array('class' => 'form-control'))))
            ->add('horasSemanales', IntegerType::class, array('label' => 'Horas Semanales', 'attr' => (array('class' => 'form-control', 'placeholder'))))
            ->add('horasTotales', IntegerType::class, array('label' => 'Horas Maximas', 'attr' => (array('class' => 'form-control', 'placeholder'))));
    }

}