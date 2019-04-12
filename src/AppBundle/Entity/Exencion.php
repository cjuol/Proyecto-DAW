<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Exencion
 *
 * @ORM\Table(name="exencion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExencionRepository")
 */
class Exencion
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
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(name="Codigo", type="string", length=9)
     */
    private $codigo;

    /**
     * @var int
     * @Assert\Type(type="int")
     * @Assert\GreaterThan(value="0")
     * @ORM\Column(name="HorasSemanales", type="integer")
     */
    private $HorasSemanales;

    /**
     * @var int
     * @Assert\Type(type="int")
     * @Assert\GreaterThan(value="0")
     * @ORM\Column(name="HorasTotales", type="integer")
     */
    private $HorasTotales;

    /**
     * @ManyToMany(targetEntity="Usuario", mappedBy="exencion",fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="usuario_extra_horas")
     * @var Collection
     */
    private $usuarios;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Exencion
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
     * @return Exencion
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
     * @return Exencion
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
        return $this->HorasSemanales;
    }

    /**
     * @param int $HorasSemanales
     * @return Exencion
     */
    public function setHorasSemanales($HorasSemanales)
    {
        $this->HorasSemanales = $HorasSemanales;
        return $this;
    }

    /**
     * @return int
     */
    public function getHorasTotales()
    {
        return $this->HorasTotales;
    }

    /**
     * @param int $HorasTotales
     * @return Exencion
     */
    public function setHorasTotales($HorasTotales)
    {
        $this->HorasTotales = $HorasTotales;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param Usuario $usuarios
     * @return Exencion
     */
    public function addUsuarios(Usuario $usuarios)
    {
        if (false === $this->usuarios->contains($usuarios)) {
            $this->usuarios[] = $usuarios;
            $usuarios->addExencion($this);
        }

        return $this;
    }

    public function removeUsuarios(Usuario $usuario)
    {
        if (true === $this->usuarios->contains($usuario)) {
            $this->usuarios->removeElement($usuario);
            $usuario->removeExencion($this);
        }

    }

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
    }

}

