<?php
/**
 * Created by Cristóbal Jurado
 * Esta clase permite generar un usuario admin  con contraseña: 123456789
 * que nos permite comenzar a utilizar nuestra aplicacion nada mas iniciarla.
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Notificacion;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Usuario_Materia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function load(ObjectManager $manager)
    {
        $u = new ArrayCollection();

        $user = new Usuario();
        $user->setCorreo('a@a.es')
            ->setNombre("admin")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Sin apellidos")
            ->setPrioridad(1)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('b@b.es')
            ->setNombre("Jose Luis")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(2)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('c@c.es')
            ->setNombre("Diego")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(3)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('d@d.es')
            ->setNombre("Blas")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(4)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('e@e.es')
            ->setNombre("María")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(5)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('f@f.es')
            ->setNombre("Olga")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(6)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('g@g.es')
            ->setNombre("Luis Ramón")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(7)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('h@h.es')
            ->setNombre("Fran")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(8)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('i@i.es')
            ->setNombre("Gregorio")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(9)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('j@j.es')
            ->setNombre("José Luis II")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(10)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('k@k.es')
            ->setNombre("Carmen")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(11)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('l@l.es')
            ->setNombre("Manuel Jesus")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(12)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        $user = new Usuario();
        $user->setCorreo('m@m.es')
            ->setNombre("Mariló")
            ->setDepartamento($this->getReference('departamento'))
            ->setApellidos("Algo")
            ->setPrioridad(13)
            ->setRol($this->getReference('admin_rol'))
            ->setClave($this->container->get('security.password_encoder')->encodePassword($user, '123456789'));
        $u[] = $user;
        foreach ($u as $o) {
            $manager->persist($o);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            DepartamentoFixtures::class,
            RolFixtures::class,
            ConfiguracionFixtures::class,
            MateriaFixtures::class
        );
    }
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}