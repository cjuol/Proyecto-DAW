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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewUserType extends  AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Usuario',
            'usuario' => null,
            'error_bubbling' => true

        ]);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $usuario = $options['usuario'];
        $builder
            ->add('correo', EmailType::class, array('label' => 'Correo: ', 'attr' => (array('class' => 'form-control', 'placeholder' => 'Introduzca su correo'))))
            ->add('nombre', TextType::class, array('label' => 'Nombre: ', 'attr' => (array('class' => 'form-control', 'placeholder' => 'Introduzca su nombre'))))
            ->add('apellidos', TextType::class, array('label' => 'Apellidos: ', 'attr' => (array('class' => 'form-control', 'placeholder' => 'Introduzca sus apellidos'))))
            ->add('prioridad', IntegerType::class, array('label' => 'Prioridad: ', 'attr' => (array('class' => 'form-control', 'placeholder' => 'Introduzca prioridad'))));
        if ('Admin' == $usuario->getRol()->getNombre()) {
            $builder
                ->add('rol',
                    EntityType::class, array('label' => 'Role: ', 'attr' => (array('class' => 'form-control')),
                        'class' => 'AppBundle\Entity\Rol',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('rol')
                                ->orderBy('rol.id', 'ASC');
                        }))
                ->add('departamento',
                    EntityType::class, array('label' => 'Departamento: ', 'attr' => (array('class' => 'form-control')),
                        'class' => 'AppBundle\Entity\Departamento',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('departamento')
                                ->orderBy('departamento.nombre');
                        }));
        } elseif ('Departamento' == $usuario->getRol()->getNombre()) {
            $builder
                ->add('rol',
                    EntityType::class, array('label' => 'Rol: ', 'attr' => (array('class' => 'form-control')),
                        'class' => 'AppBundle\Entity\Rol',
                        'query_builder' => function (EntityRepository $er) {
                            $rol = $er->createQueryBuilder('rol')
                                ->where('rol.nombre = :rol')
                                ->setParameter('rol', 'Departamento')
                                ->getQuery()
                                ->getResult();
                            return $er->createQueryBuilder('rol')
                                ->where('rol.id >= :rol')
                                ->setParameter('rol', $rol)
                                ->orderBy('rol.id', 'ASC');
                        }));
        }
    }

}