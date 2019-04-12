<?php
/**
 * Created by Cristóbal Jurado
 * Esta clase permite generar un usuario admin  con contraseña: 123456789
 * que nos permite comenzar a utilizar nuestra aplicacion nada mas iniciarla.
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Exencion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class ExencionFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $m = new ArrayCollection();

        $exencion = new Exencion();
        $exencion->setNombre('Lactancia')
            ->setHorasSemanales(10)
            ->setHorasTotales(3600)
            ->setCodigo('LTC');
        $m[] = $exencion;

        $exencion = new Exencion();
        $exencion->setNombre('Mayores de 55')
            ->setHorasSemanales(10)
            ->setHorasTotales(500)
            ->setCodigo('M55');
        $m[] = $exencion;

        $exencion = new Exencion();
        $exencion->setNombre('tutor')
            ->setHorasSemanales(2)
            ->setHorasTotales(200)
            ->setCodigo('LTC');
        $m[] = $exencion;

        foreach ($m as $o) {
            $manager->persist($o);
        }

        $manager->flush();
    }

}