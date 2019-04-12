<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Notificacion;
use AppBundle\Entity\Usuario;
use Exception;

/**
 * ConfiguracionRepository
 *
 * Clase en la que tendremos los distintos accesos a datos y funciones importantes para la entidad Configuracion
 */
class ConfiguracionRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Función utilizada para guardar una variable del tipo Configuracion en la base de datos.
     *
     * Esta función devuelve un valor entre 0 o 1.
     * Devolvera 0 si no ha podido realizarse la accion correctamente.
     * Devolvera 1 si la operación se ha realizado correctamente.
     *
     * @param Configuracion $configuracion
     * @return int
     */
    public function guardarConfiguracion(Configuracion $configuracion)
    {
        $resultado = 0;
        try {
            $this->_em->persist($configuracion);
            $this->_em->flush();
            $resultado = 1;
        } catch (Exception $e) {
            $resultado = 0;
        } finally {
            return $resultado;
        }
    }

    /**
     * Este metodo realiza un acceso a  la base de datos para devolvernos el ultimo registro de la tabla
     * Configuracion, en caso de no encontrar ningun resultado nos devolverá un  objeto del tipo Configuracion vacio
     *
     * @return Configuracion
     */
    public function encontrarConfiguracion()
    {
        $resultado = $this->createQueryBuilder('configuracion')
            ->orderBy('configuracion.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        $resultado = ($resultado != null) ? $resultado[0] : new Configuracion();
        return $resultado;
    }


}
