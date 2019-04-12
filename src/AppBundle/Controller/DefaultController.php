<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Exencion;
use AppBundle\Entity\Materia;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Usuario_Materia;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name = "homepage")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {

        return $this->render('@App/default/index.html.twig', [
        ]);
    }

    /**
     * @Route("/seleccion", name = "seleccion")
     * @Security("has_role('ROLE_USER')")
     */
    public function selectAction()
    {
        $config = $this->getDoctrine()->getRepository(Configuracion::class)->encontrarConfiguracion();
        $exenciones = $this->getDoctrine()->getRepository(Exencion::class)->encontrarExencionesRestantes($this->getUser());
        $materias = $this->getDoctrine()->getRepository(Materia::class)->encontrarMateriasRestantes($this->getUser());
        $usuario_materia = $this->getDoctrine()->getRepository(Usuario_Materia::class)->encontrarPorCursoYDepartamento($this->getUser(), $config);
        $m = $this->getDoctrine()->getRepository(Usuario::class)->getPorcentajeMateriasAsignadas($this->getUser());
        $e = $this->getDoctrine()->getRepository(Usuario::class)->getPorcentajeExencionesAsignadas($this->getUser());

        $m = ($m /$config->getHorasMin()) * 100;
        $e = ($e /$config->getHorasMin()) * 100;

        $m = round($m, 2);
        $e = round($e, 2);

        return $this->render('@App/default/seleccion.html.twig', [
            'exenciones' => $exenciones,
            'materias' => $materias,
            'usuario_materia' => $usuario_materia,
            'm' => $m,
            'e' => $e,
            'config' => $config
        ]);
    }
}
