<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Rol;
use Doctrine\ORM\EntityRepository;

/**
 * RoleRepository
 *
 * Clase en la que tendremos los distintos accesos a datos y funciones importantes para la entidad Rol
 * No requiere funciones de creación y eliminación de Roles ya que estos datos son estaticos y no se modificaran.
 */
class RolRepository extends EntityRepository
{
    /**
     * Esta funcion permite encontrar un rol introduciendo su nombre
     * nos devolvera un unico valor.
     *
     * @param string $rol
     * @return Rol
     */
    public function encontrarRol($rol)
    {
        $resultado = $this->createQueryBuilder('rol')
            ->where('rol.nombre = :rol')
            ->setParameters(array(
                'rol' => $rol
            ))
            ->getQuery()
            ->getResult();
        return $resultado[0];
    }
}
