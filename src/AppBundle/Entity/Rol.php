<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 *
 * Esta tabla va a guardar los roles que podemos tener en la aplicacion para luego asignarle un rol de symfony.
 * La aplicación funciona con los roles 'Admin','Departamento' y 'Usuario' que se asocian respectivamente a los roles
 * de symfony ['ROLE_ADMIN'],['ROLE_DEPARTMENT'] y ['ROLE_USER']
 *
 * El rol Administrador esta asociado al Jefe de Estudios del instituto.
 * El rol Departamento se asigna a todos los jefes de departamento.
 * Y el rol Usuario lo tendran todos los profesores que no desempeñan ninguna de las funciones citadas anteriormente.
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RolRepository")
 */
class Rol
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Aquí asignaremos el valor 'Admin', 'Departamento' o 'Usuario' que se utilizara  en la entidad Usuario para
     * asignar un rol symfony concreto.
     *
     * @var string
     * @ORM\Column(name="nombre", type="string", nullable = false)
     */
    private $nombre;

    /**
     * Hace referencia a todos los usuarios que tienen este rol
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Usuario", mappedBy="rol")
     * @var Collection
     */
    private $usuario;

    /**
     * Rol constructor.
     * Requiere  inicializar los usuarios para poder implementar la relación correctamente facilitando el trabajo
     * y permitiendo asignar  nuevos usuarios o eliminarlos de forma bi-direccional
     */
    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }

    /**
     * El toString nos permite hacer referencia a rol y que muestre ciertos datos, en este caso
     * nos interesa mostrar el nombre
     *
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
     * @return Rol
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
     * @return Rol
     */
    public function setNombre($nombre)
    {
        $this->nombre = ucfirst($nombre);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUsuarios()
    {
        return $this->usuario;
    }

    /**
     * Metodo  que sustituye al setter de usuarios ya que dicha variable está inicializada como un ArrayCollection
     * Este metodo nos permite añadir un Usuario al ArrayCollection
     *
     * @param Usuario $usuario
     * @return $this
     */
    public function addUsuario(Usuario $usuario)
    {
        if (!$this->usuario->contains($usuario)) {
            $this->usuario = $usuario;
        }
        return $this;
    }

    /**
     * Metodo  que sustituye al setter de usuarios ya que dicha variable está inicializada como un ArrayCollection
     * Este metodo nos permite eliminar un Usuario al ArrayCollection
     * @param Usuario $usuario
     */
    public function removeUsuario(Usuario $usuario)
    {
        if ($this->usuario->contains($usuario)) {
            $this->usuario->removeElement($usuario);
        }
    }

}

