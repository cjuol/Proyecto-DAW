<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Departamento
 *
 * @ORM\Table(name="departamento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartamentoRepository")
 */
class Departamento
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\Regex(pattern="/^([^0-9]*)$/")
     * @ORM\Column(name="Nombre", type="string", length=50)
     * @Assert\Length(max="50")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Materia", mappedBy="departamento", fetch="EXTRA_LAZY")
     */
    private $materia;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Usuario", mappedBy="departamento", fetch="EXTRA_LAZY")
     */
    private $usuario;

    /**
     * Departamento constructor.
     */
    public function __construct()
    {
        $this->materia = new ArrayCollection();
        $this->usuario = new ArrayCollection();
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
     * @return Departamento
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
     * @return Departamento
     */
    public function setNombre($nombre)
    {

        $this->nombre = ucfirst($nombre);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * @param mixed $materia
     * @return Departamento
     */
    public function addMateria(Materia $materia)
    {
        if (false === $this->materia->contains($materia)) {
            $this->materia[] = $materia;
            $materia->setDepartamento($this);
        }

        return $this;
    }

    /**
     * @param Materia $materia
     */
    public function removeMateria(Materia $materia)
    {
        if (true === $this->materia->contains($materia)) {
            $this->materia->removeElement($materia);
            $materia->setDepartamento(null);
        }
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     * @return $this
     */
    public function addUsuario(Usuario $usuario)
    {
        if (false === $this->usuario->contains($usuario)) {
            $this->usuario[] = $usuario;
            $usuario->setDepartamento($this);
        }

        return $this;
    }

    /**
     * @param Usuario $usuario
     */
    public function removeUsuario(Usuario $usuario)
    {
        if (true === $this->usuario->contains($usuario)) {
            $this->usuario->removeElement($usuario);
            $usuario->setDepartamento(null);
        }
    }

    public function findAdmin()
    {
        $resultado = null;
        foreach ($this->usuario as $u) {
            if ($u->getRol() == 'Departamento') {
                $resultado = $u;
            }
        }
        if ($resultado == null) {
            foreach ($this->usuario as $u) {
                if ($u->getRol() == 'Admin') {
                    $resultado = $u;
                }
            }
        }
        return $resultado;
    }
}

