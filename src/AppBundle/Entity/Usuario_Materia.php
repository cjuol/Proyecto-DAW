<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario_Materia
 *
 * @ORM\Table(name="usuario_materia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Usuario_MateriaRepository")
 */
class Usuario_Materia
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="usuario_materia", fetch="EXTRA_LAZY")
     * @var Usuario
     * @ORM\Id()
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Materia", inversedBy="usuario_materia",fetch="EXTRA_LAZY")
     * @var Materia
     * @ORM\Id()
     */
    private $materia;
    /**
     * @var string
     * @ORM\Column(name="Curso", type="string", length=255)
     */
    private $curso;

    /**
     * @var int
     * @ORM\Column(name="Turno", type="integer")
     */
    private $turno = 0;

    public function __toString()
    {
        return $this->getUsuario() . ' - ' . $this->getMateria();
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     * @return Usuario_Materia
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return Materia
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * @param Materia $materia
     * @return Usuario_Materia
     */
    public function setMateria($materia)
    {
        $this->materia = $materia;
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
     * @return Usuario_Materia
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
     * @return Usuario_Materia
     */
    public function setTurno($turno)
    {
        $this->turno = $turno;
        return $this;
    }


}

