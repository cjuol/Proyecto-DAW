<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Departamento;
use AppBundle\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * DepartamentoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DepartamentoRepository extends EntityRepository
{

    /**
     * @param Departamento $departamento
     * @return int
     */
    public function guardarDepartamento(Departamento $departamento)
    {
        try {
            $this->_em->persist($departamento);
            $this->_em->flush();
            return 1;
        } catch (Exception $e) {
            dump($e);
            return 0;
        } catch (OptimisticLockException $e) {
            return 0;
        }
    }

    /**
     * @param Departamento $departamento
     * @return int
     */
    public function borrarDepartamento(Departamento $departamento)
    {
        try {
            foreach ($departamento->getUsuario() as $u) {
                $this->_em->remove($u);
            }
            foreach ($departamento->getMateria() as $m) {
                $this->_em->remove($m);
            }
            $this->_em->remove($departamento);
            $this->_em->flush();
            return 1;
        } catch (Exception $e) {
            return 0;
        } catch (OptimisticLockException $e) {
            return 0;
        }
    }

    /**
     * @param Usuario $usuario
     * @return array
     */
    public function encontrarTodosDepartamentos(Usuario $usuario)
    {
        if ('Admin' == $usuario->getRol()) {
            $resultado = $this->createQueryBuilder('departamento')
                ->getQuery()
                ->getResult();
        } else {
            $resultado = $this->createQueryBuilder('departamento')
                ->where('departamento.id = :departamento')
                ->setParameters(array(
                    'departamento' => $usuario->getDepartamento()
                ))
                ->getQuery()
                ->getResult();
        }
        return $resultado;
    }


}
