<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Configuracion
 *
 * Entidad generada para guardar parametros importantes para garantizar el funcionamiento completo de la aplicación
 *
 * @ORM\Table(name="configuracion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfiguracionRepository")
 */
class Configuracion
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Este campo guarda las horas minimas que deben seleccionar los distintos usuarios.
     * El valor de esta variable debe ser menor o igual que el de la variable $horasMax
     *
     * Este variable se inicializa automaticamente a 0
     *
     * @var int
     * @Assert\GreaterThan(value="0")
     * @Assert\Type(type="int")
     * @ORM\Column(name="HorasMin", type="integer", nullable=true)
     */
    private $horasMin = 0;

    /**
     * Este campo guarda las horas maximas que pueden seleccionar los distintos usuarios.
     * El valor de esta variable debe ser mayor o igual que el de la variable $horasMin
     *
     * Este variable se inicializa automaticamente a 0
     * @Assert\GreaterThan(value="0")
     * @Assert\Type(type="int")
     * @var int
     * @ORM\Column(name="HorasMax", type="integer", nullable=true)
     */
    private $horasMax = 0;

    /**
     * Esta variable almacena el curso escolar en el que nos encontramos, este dato es importante para
     * realizar algunos historicos. El valor de este campo se asigna automaticamente a la entidad Usuario_Materia
     * en el campo $curso.
     * @Assert\Length(max="12")
     * @var string
     * @ORM\Column(name="Curso", type="string", length=12, nullable=true)
     */
    private $curso;

    /**
     * Metodo utilizado para mostrar el curso escolar en el que nos encontramos actualmente haciendo referencia a la
     * configuración.
     * @return string
     */
    public function __toString()
    {
        return $this->getCurso();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Configuracion
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getHorasMin()
    {
        return $this->horasMin;
    }

    /**
     * @param int $horasMin
     * @return Configuracion
     */
    public function setHorasMin($horasMin)
    {
        $this->horasMin = $horasMin;
        return $this;
    }

    /**
     * @return int
     */
    public function getHorasMax()
    {
        return $this->horasMax;
    }

    /**
     * @param int $horasMax
     * @return Configuracion
     */
    public function setHorasMax($horasMax)
    {
        $this->horasMax = $horasMax;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param string $curso
     * @return Configuracion
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;
        return $this;
    }

    /**
     * @return int
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * @param int $turno
     * @return Configuracion
     */
    public function setTurno($turno)
    {
        $this->turno = $turno;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * @param int $prioridad
     * @return Configuracion
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
        return $this;
    }

}

