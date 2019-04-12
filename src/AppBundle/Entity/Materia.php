<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Materia
 *
 * @ORM\Table(name="materia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MateriaRepository")
 */
class Materia
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="Nombre", type="string", length=50)
     * @Assert\Length(max="50")
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(name="Code", type="string", length=9)
     * @Assert\Length(max="9")
     */
    private $codigo;

    /**
     * @var int
     * @Assert\GreaterThan(value="0")
     * @Assert\Type(type="int")
     * @ORM\Column(name="HorasSemanales", type="integer")
     */
    private $horasSemanales;

    /**
     * @var int
     * @Assert\GreaterThan(value="0")
     * @Assert\Type(type="int")
     * @ORM\Column(name="HorasTotales", type="integer")
     */
    private $horasTotales;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departamento", inversedBy="materia", fetch="EXTRA_LAZY")
     */
    private $departamento;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Usuario_Materia", mappedBy="materia", fetch="EXTRA_LAZY")
     * @var Usuario_Materia
     */
    private $usuario_materia;

    /**
     * @var string
     * @ORM\Column(name="Curso", type="string", length=12)
     * @Assert\Length(max="12")
     */
    private $curso;

    /**
     * Materia constructor.
     */
    public function __construct()
    {
        $this->usuario_materia = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre();
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
     * @return Materia
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Materia
     */
    public function setNombre($nombre)
    {
        $this->nombre = ucfirst($nombre);
        return $this;
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     * @return Materia
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return int
     */
    public function getHorasSemanales()
    {
        return $this->horasSemanales;
    }

    /**
     * @param int $horasSemanales
     * @return Materia
     */
    public function setHorasSemanales($horasSemanales)
    {
        $this->horasSemanales = $horasSemanales;
        return $this;
    }

    /**
     * @return int
     */
    public function getHorasTotales()
    {
        return $this->horasTotales;
    }

    /**
     * @param int $horasTotales
     * @return Materia
     */
    public function setHorasTotales($horasTotales)
    {
        $this->horasTotales = $horasTotales;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param mixed $departamento
     * @return Materia
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
        return $this;
    }

    /**
     * @return Usuario_Materia
     */
    public function getUsuarioMateria()
    {
        return $this->usuario_materia;
    }

    /**
     * @param Usuario_Materia $usuario_Materia
     * @return $this
     */
    public function addUsuarioMateria(Usuario_Materia $usuario_Materia)
    {
        if (!$this->usuario_materia->contains($usuario_Materia)) {
            $this->usuario_materia[] = $usuario_Materia;
            $usuario_Materia->setMateria($this);
        }
        return $this;
    }

    /**
     * @param Usuario_Materia $usuario_Materia
     * @return $this
     */
    public function removeUsuarioMateria(Usuario_Materia $usuario_Materia)
    {
        if ($this->usuario_materia->contains($usuario_Materia)) {
            $this->usuario_materia->removeElement($usuario_Materia);
            $usuario_Materia->setMateria(null);
        }
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
     * @return Materia
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;
        return $this;
    }

}

