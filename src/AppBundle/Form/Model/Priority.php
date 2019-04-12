<?php
/**
 * Created by PhpStorm.
 * User: Equipo
 * Date: 12/12/2017
 * Time: 9:18
 */

namespace AppBundle\Form\Model;

class Priority
{

    /**
     * @var int
     */
    protected $prioridad = 0;

    /**
     * @return int
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * @param int $prioridad
     * @return Priority
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
        return $this;
    }

}