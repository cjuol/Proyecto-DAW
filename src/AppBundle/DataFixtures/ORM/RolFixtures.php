<?php
/**
 * Created by Cristóbal Jurado
 * Esta clase permite generar un usuario admin  con contraseña: 123456789
 * que nos permite comenzar a utilizar nuestra aplicacion nada mas iniciarla.
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Rol;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class RolFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $r = new ArrayCollection();

        $rol = new Rol();
        $rol->setNombre('Admin');
        $r[] = $rol;

        $this->addReference('admin_rol', $rol);

        $rol = new Rol();
        $rol->setNombre('Departamento');
        $r[] = $rol;

        $this->addReference('departamento_rol', $rol);

        $rol = new Rol();
        $rol->setNombre('Usuario');
        $r[] = $rol;

        $this->addReference('usuario_rol', $rol);

        foreach ($r as $o) {
            $manager->persist($o);
        }
        $manager->flush();
    }

}