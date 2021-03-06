<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Exencion;
use AppBundle\Entity\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * ExencionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExencionRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param Exencion $exencion
     * @return int
     */
    public function guardarExencion(Exencion $exencion)
    {
        try {
            $this->_em->persist($exencion);
            $this->_em->flush();
            return 1;
        } catch (Exception $e) {
            return 0;
        } catch (OptimisticLockException $e) {
            return 0;
        }
    }

    /**
     * @param Exencion $exencion
     * @return int
     */
    public function borrarExencion(Exencion $exencion)
    {
        try {
            $this->_em->remove($exencion);
            $this->_em->flush();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * @return array
     */
    public function encontrarExenciones()
    {
        $result = $this->createQueryBuilder('exencion')
            ->orderBy('exencion.nombre')
            ->getQuery()
            ->getResult();
        return $result;
    }

    /**
     * @param $nombre
     * @return mixed
     */
    public function encontrarExencionNombre($nombre)
    {
        $resultado = $this->createQueryBuilder('exencion')
            ->where('exencion.nombre = :nombre')
            ->setParameters(array(
                'nombre' => $nombre
            ))
            ->getQuery()
            ->getResult();
        return $resultado[0];
    }

    /**
     * @param Usuario $usuario
     * @return array|ArrayCollection
     */
    public function encontrarExencionesRestantes(Usuario $usuario)
    {
        $config = $this->_em->getRepository(Configuracion::class)->encontrarConfiguracion();
        $horas = $this->_em->getRepository(Usuario::class)->getHorasAsignadas($usuario);
        $exenciones = $this->encontrarExenciones();
        $resultado = new ArrayCollection();
        foreach ($exenciones as $e) {
            if (!$e->getUsuarios()->contains($usuario)) {
                if (($horas + $e->getHorasSemanales()) <= $config->getHorasMax()){
                    $resultado[] = $e;
                }
            }
        }
        return $resultado;
    }

}
