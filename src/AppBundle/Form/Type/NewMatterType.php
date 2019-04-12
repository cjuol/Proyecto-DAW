<?php
/**
 * Created by PhpStorm.
 * Usuario: Equipo
 * Date: 30/10/2017
 * Time: 9:32
 */

namespace AppBundle\Form\Type;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewMatterType extends  AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Materia',
            'usuario' => null
        ]);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $usuario = $options['usuario'];
        $builder
            ->add('nombre', TextType::class, array('label' => 'Nombre: ', 'attr' => (array('class' => 'form-control'))))
            ->add('codigo', TextType::class, array('label' => 'Código: ', 'attr' => (array('class' => 'form-control'))))
            ->add('curso', TextType::class, array('label' => 'Curso: ', 'attr' => (array('class' => 'form-control'))));
        if ('Admin' == $usuario->getRol()) {
            $builder->add('departamento',
                EntityType::class, array('label' => 'Departamento: ', 'attr' => (array('class' => 'form-control')),
                    'class' => 'AppBundle\Entity\Departamento',
                    'query_builder' => function(EntityRepository $er){
                        return $er->createQueryBuilder('departamento')
                            ->orderBy('departamento.nombre');
                    }));

        } elseif ('Departamento' == $usuario->getRol()) {
            $builder->add('departamento',
                TextType::class, array('label' => 'Departamento: ', 'attr' => (array('class' => 'form-control')),
                    'data' => $usuario->getDepartamento(),
                    'disabled' => 'true'));
        }

        $builder->add('horasSemanales', IntegerType::class, array('label' => 'Horas Semanales', 'attr' => (array('class' => 'form-control', 'placeholder'))))
            ->add('horasTotales', IntegerType::class, array('label' => 'Horas Maximas', 'attr' => (array('class' => 'form-control', 'placeholder'))));
    }

}