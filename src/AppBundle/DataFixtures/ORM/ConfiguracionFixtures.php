<?php
/**
 * Created by Cristóbal Jurado
 * Esta clase permite generar un usuario admin  con contraseña: 123456789
 * que nos permite comenzar a utilizar nuestra aplicacion nada mas iniciarla.
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Configuracion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ConfiguracionFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $config = new Configuracion();
        $config->setCurso("2018/2019")
            ->setHorasMin(15)
            ->setHorasMax(20);
        $manager->persist($config);
        $manager->flush();
        $this->setReference('config', $config);
    }

}