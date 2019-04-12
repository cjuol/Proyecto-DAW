<?php
/**
 * Created by Cristóbal Jurado
 * Esta clase permite generar un usuario admin  con contraseña: 123456789
 * que nos permite comenzar a utilizar nuestra aplicacion nada mas iniciarla.
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Departamento;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class DepartamentoFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $d = new ArrayCollection();

        $department = new Departamento();
        $department->setNombre('Sanidad');
        $d[] = $department;

        $department = new Departamento();
        $department->setNombre('Filosofia');
        $d[] = $department;

        $department = new Departamento();
        $department->setNombre('Historia');
        $d[] = $department;

        $department = new Departamento();
        $department->setNombre('Matemáticas');
        $d[] = $department;

        $department = new Departamento();
        $department->setNombre('Informática');
        $d[] = $department;
        foreach ($d as $o) {
            $manager->persist($o);
        }
        $manager->flush();
        $this->addReference('departamento', $department);
    }

}