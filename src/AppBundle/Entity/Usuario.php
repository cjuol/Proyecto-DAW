<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuario
 * @UniqueEntity(fields = {"correo"})
 * @ORM\Table(name = "usuario")
 * @ORM\Entity(repositoryClass = "AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Length(max="50")
     * @Assert\Regex(pattern="/^([^0-9]*)$/")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @var string
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Regex(pattern="/^([^0-9]*)$/")
     * @Assert\Length(max="50")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @var string
     */
    protected $apellidos;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $clave = "K60DdeDe0BkgvLuZpNsoCK6ENp8=";

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $hash = "K60DdeDe0BkgvLuZpNso";
    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var boolean
     */
    protected $isHashActive = false;
    /**
     * @ORM\Column(type="string", nullable=false, unique = true)
     * @Assert\Email()
     * @var string
     */
    protected $correo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="int")
     * @Assert\GreaterThan(0)
     * @var int
     */
    protected $prioridad;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departamento", inversedBy="usuario" ,fetch="EXTRA_LAZY")
     * @var Departamento
     */
    private $departamento;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Usuario_Materia", mappedBy="usuario", fetch="EXTRA_LAZY")
     * @var Usuario_Materia
     */
    private $usuario_materia;

    /**
     * @ManyToMany(targetEntity="Exencion", inversedBy="usuarios",fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="usuario_exencion")
     * @var Exencion
     */
    private $exencion;

    /**
     * @ORM\ManyToOne(targetEntity="Rol", inversedBy="usuario" ,fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="role_usuario")
     * @var Rol
     */
    private $rol;

    public function __toString()
    {
        return $this->getNombre();
    }

    public function __construct()
    {
        $this->exencion = new ArrayCollection();
        $this->usuario_materia = new ArrayCollection();
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
     * @return Usuario
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
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = ucfirst($nombre);
        return $this;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = ucfirst($apellidos);
        return $this;
    }

    /**
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param string $clave
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
        return $this;
    }

    /**
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     * @return Usuario
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
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
     * @return Usuario
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     *
     * @param string $hash
     * @return Usuario
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHashActive()
    {
        return $this->isHashActive;
    }

    /**
     * @param bool $isHashActive
     * @return Usuario
     */
    public function setIsHashActive($isHashActive)
    {
        $this->isHashActive = $isHashActive;
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
     * @return Usuario
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
        return $this;
    }

    /**
     * @return mixed
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
        }
        return $this;
    }

    /**
     * @param Usuario_Materia $usuario_Materia
     */
    public function removeUsuarioMateria(Usuario_Materia $usuario_Materia)
    {
        if ($this->usuario_materia->contains($usuario_Materia)) {
            $this->usuario_materia->removeElement($usuario_Materia);
        }
    }

    /**
     * @return Rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @param Rol $role
     * @return Usuario
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getExencion()
    {
        return $this->exencion;
    }

    /**
     * @param Exencion $exencion
     * @return $this
     */
    public function addExencion(Exencion $exencion)
    {
        if (!$this->exencion->contains($exencion)) {
            $this->exencion[] = $exencion;
            $exencion->addUsuarios($this);
        }
        return $this;
    }

    /**
     * @param Exencion $exencion
     */
    public function removeExencion(Exencion $exencion)
    {
        if ($this->exencion->contains($exencion)) {
            $this->exencion->removeElement($exencion);
        }
    }



//---------------------------------------------------Gestion de Usuarios------------------------------------------------------

    /**
     * Returns the roles granted to the user.
     *
     * @return Rol[] The user roles
     */
    public function getRoles()
    {
        $roles = array();

        if ($this->getRol() == 'Departamento') {
            array_push($roles, new Role('ROLE_DEPARTMENT'));
        } elseif ($this->getRol() == 'Admin') {
            array_push( $roles, new Role('ROLE_ADMIN'));
        } else {
            array_push( $roles, new Role('ROLE_USER'));

        }
        return $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials()
    {
    }

    /**
     * Returns the password used to authenticate the user.
     * @return string The password
     */
    public function getPassword()
    {
        return $this->getClave();

    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getCorreo();

    }

}

