<?php
/**
 * Created by Cristóbal Jurado
 * Esta clase permite generar un usuario admin  con contraseña: 123456789
 * que nos permite comenzar a utilizar nuestra aplicacion nada mas iniciarla.
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Materia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class MateriaFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $m = new ArrayCollection();
        $matter = new Materia();
        $matter->setNombre('Sistemas Informáticos')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º DAW')
            ->setCodigo('SI')
            ->setHorasTotales(134)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Sistemas Informáticos (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º DAW')
            ->setCodigo('SI-B')
            ->setHorasTotales(66)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Base de Datos')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º DAW')
            ->setCodigo('BD')
            ->setHorasTotales(134)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Base de Datos (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º DAW')
            ->setCodigo('BD-B')
            ->setHorasTotales(66)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Programación')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º DAW')
            ->setCodigo('PR')
            ->setHorasTotales(149)
            ->setHorasSemanales(8);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Programación (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º DAW')
            ->setCodigo('PR-B')
            ->setHorasTotales(111)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Lenguajes de Marcas y Sistemas de Gestión de Información')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º DAW')
            ->setCodigo('LMSG')
            ->setHorasTotales(120)
            ->setHorasSemanales(4);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Entornos de Desarrollo')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º DAW')
            ->setCodigo('ED')
            ->setHorasTotales(90)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Desarrollo web en entorno cliente')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º DAW')
            ->setCodigo('DWEC')
            ->setHorasTotales(125)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Desarrollo web en entorno servidor')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º DAW')
            ->setCodigo('DWES')
            ->setHorasTotales(160)
            ->setHorasSemanales(8);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Despliegue de aplicaciones web')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º DAW')
            ->setCodigo('DDAW')
            ->setHorasTotales(63)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Horas de libre configuración')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º DAW')
            ->setCodigo('HLC')
            ->setHorasTotales(63)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Proyecto de desarrollo de aplicaciones web')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º DAW')
            ->setCodigo('PDAW')
            ->setHorasTotales(40)
            ->setHorasSemanales(0);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Formación en centros de trabajo')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º DAW')
            ->setCodigo('FCT')
            ->setHorasTotales(400)
            ->setHorasSemanales(0);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Diseño de interfaces WEB')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º DAW')
            ->setCodigo('DIW')
            ->setHorasTotales(125)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Implantación de Sistemas Operativos')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º ASIR')
            ->setCodigo('ISO')
            ->setHorasTotales(256)
            ->setHorasSemanales(8);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Implantación de Sistemas Operativos (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º ASIR')
            ->setCodigo('ISO')
            ->setHorasTotales(256)
            ->setHorasSemanales(4);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Planificación y Administración de Redes')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º ASIR')
            ->setCodigo('PAR')
            ->setHorasTotales(192)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Planificación y Administración de Redes (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º ASIR')
            ->setCodigo('PAR')
            ->setHorasTotales(192)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Fundamentos de Hardware')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º ASIR')
            ->setCodigo('FH')
            ->setHorasTotales(96)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Gestión de Bases de Datos')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º ASIR')
            ->setCodigo('GBD')
            ->setHorasTotales(192)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Gestión de Bases de Datos (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º ASIR')
            ->setCodigo('GBD')
            ->setHorasTotales(192)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Lenguajes de Marcas y Sistemas de Gestión de Información')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º ASIR')
            ->setCodigo('LMS')
            ->setHorasTotales(128)
            ->setHorasSemanales(4);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Administración de Sistemas Operativos')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('ASO')
            ->setHorasTotales(126)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Administración de Sistemas Operativos (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('ASO')
            ->setHorasTotales(126)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Servicios de Red e Internet')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('SRI')
            ->setHorasTotales(126)
            ->setHorasSemanales(6);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Servicios de Red e Internet (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('SRI')
            ->setHorasTotales(126)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Implantación de Aplicaciones Web')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('IAW')
            ->setHorasTotales(84)
            ->setHorasSemanales(4);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Implantación de Aplicaciones Web (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('IAW')
            ->setHorasTotales(84)
            ->setHorasSemanales(2);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Administración de Sistemas Gestores de Bases de Datos')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('ASDB')
            ->setHorasTotales(63)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Seguridad y Alta Disponibilidad')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('SAD')
            ->setHorasTotales(884)
            ->setHorasSemanales(4);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Horas de libre configuración')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('HLC')
            ->setHorasTotales(63)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Proyecto de administración de Sistemas Informáticos en Red ')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('PIR')
            ->setHorasTotales(40)
            ->setHorasSemanales(0);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Formación en centros de trabajo')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º ASIR')
            ->setCodigo('FCT')
            ->setHorasTotales(370)
            ->setHorasSemanales(0);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Montaje y Mantenimiento de Equipos')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º SMR')
            ->setCodigo('MME')
            ->setHorasTotales(224)
            ->setHorasSemanales(7);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Montaje y Mantenimiento de Equipos (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º SMR')
            ->setCodigo('MME')
            ->setHorasTotales(224)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Sistemas Operativos Monopuesto')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º SMR')
            ->setCodigo('SOM')
            ->setHorasTotales(160)
            ->setHorasSemanales(5);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Aplicaciones Ofimáticas')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º SMR')
            ->setCodigo('AO')
            ->setHorasTotales(256)
            ->setHorasSemanales(8);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Aplicaciones Ofimáticas (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º SMR')
            ->setCodigo('AO')
            ->setHorasTotales(256)
            ->setHorasSemanales(4);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Redes Locales')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º SMR')
            ->setCodigo('RL')
            ->setHorasTotales(224)
            ->setHorasSemanales(7);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Redes Locales (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º SMR')
            ->setCodigo('RL')
            ->setHorasTotales(224)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Sistemas Operativos en Red')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º SMR')
            ->setCodigo('SOR')
            ->setHorasTotales(147)
            ->setHorasSemanales(7);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Sistemas Operativos en Red (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º SMR')
            ->setCodigo('SOR')
            ->setHorasTotales(147)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Seguridad Informática')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º SMR')
            ->setCodigo('SI')
            ->setHorasTotales(105)
            ->setHorasSemanales(5);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Servicios en Red')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º SMR')
            ->setCodigo('SR')
            ->setHorasTotales(147)
            ->setHorasSemanales(7);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Servicios en Red (Desdoble)')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º SMR')
            ->setCodigo('SR')
            ->setHorasTotales(147)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Aplicaciones Web')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º SMR')
            ->setCodigo('AW')
            ->setHorasTotales(84)
            ->setHorasSemanales(4);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Horas de libre configuración')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º SMR')
            ->setCodigo('HLC')
            ->setHorasTotales(63)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Formación en centros de trabajo')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º SMR')
            ->setCodigo('FCT')
            ->setHorasTotales(410)
            ->setHorasSemanales(0);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('Informática')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('4º ESO')
            ->setCodigo('4ESO_A')
            ->setHorasTotales(96)
            ->setHorasSemanales(3);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('TIC')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('1º BACH')
            ->setCodigo('1BACH')
            ->setHorasTotales(64)
            ->setHorasSemanales(2);
        $m[] = $matter;
        $matter = new Materia();
        $matter->setNombre('TIC')
            ->setDepartamento($this->getReference('departamento'))
            ->setCurso('2º BACH')
            ->setCodigo('2BACH')
            ->setHorasTotales(128)
            ->setHorasSemanales(4);
        $m[] = $matter;
        foreach ($m as $o) {
            $manager->persist($o);
        }
        $manager->flush();
        $this->addReference('matter', $matter);

    }

    public function getDependencies()
    {
        return array(
            DepartamentoFixtures::class
        );
    }
}