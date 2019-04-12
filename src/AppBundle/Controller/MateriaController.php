<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Materia;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Usuario_Materia;
use AppBundle\Form\Type\NewMatterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MateriaController extends Controller
{


    /**
     * @Route("/materias/", name = "listMatter")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        $materia = $this->getDoctrine()->getRepository(Materia::class)->encontrarTodasMaterias($this->getUser());
        return $this->render('@App/matter/index.html.twig', array(
            'materias' => $materia
        ));

    }

    /**
     * @Route("/materias/nueva", name = "newMatter")
     * @Route("/materias/modificar/matter={id}", name = "modMatter")
     * @Security("has_role('ROLE_DEPARTMENT')")
     */
    public function newMatterAction(Request $request)
    {
        $materia = new Materia();
        $form = $this->createForm(NewMatterType::class, $materia, array('usuario' => $this->getUser()));
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if ($materia->getHorasSemanales() >= $materia->getHorasTotales()){
                $this->get('session')->getFlashBag()->add('notice',
                    'matter_notadded'
                );
                return $this->redirectToRoute('newMatter');
            }
            if ($form->isValid()) {
                $resultado = $this->getDoctrine()->getRepository(Materia::class)->guardarMateria($materia);
                if (1 === $resultado) {
                    $this->get('session')->getFlashBag()->add('notice',
                        'matter_added');
                } else {
                    $this->get('session')->getFlashBag()->add('notice',
                        'matter_notadded'
                    );
                }
                return $this->redirectToRoute('listMatter');
            }else {
                $this->get('session')->getFlashBag()->add('notice',
                    'matter_notadded'
                );
                return $this->redirectToRoute('newMatter');

            }
        }
        return $this->render('AppBundle:matter:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/materias/detalle/matter={id}", name = "profileMatter")
     * @Security("has_role('ROLE_USER')")
     */
    public function profileAction(Request $request, Materia $materia)
    {
        $form = $this->createForm(NewMatterType::class, $materia, array('usuario' => $this->getUser()));
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if ($materia->getHorasSemanales() >= $materia->getHorasTotales()){
                $this->get('session')->getFlashBag()->add('notice',
                    'matter_notedited'
                );
                return $this->redirectToRoute('profileMatter', array('id' => $materia->getId()));
            }
            if ($form->isValid()) {
                $resultado = $this->getDoctrine()->getRepository(Materia::class)->guardarMateria($materia);
                if (1 === $resultado) {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'user_edited'
                    );

                } else {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'user_notedited'
                    );
                }
                return $this->redirectToRoute('profileMatter', array('id' => $materia->getId()));
            }else {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'user_notedited'
                );
                return $this->redirectToRoute('profileMatter', array('id' => $materia->getId()));

            }
        }
        return $this->render('@App/matter/profile.html.twig', [
            'form' => $form->createView(),
            'materia' => $materia]);
    }

    /**
     * @Route("/materia/detalle/borrar/matter={id}", name = "deleteMateria")
     * @Security("has_role('ROLE_DEPARTMENT')")
     */
    public function deleteAction(Materia $materia)
    {
        $resultado = $this->getDoctrine()->getRepository(Materia::class)->borrarMateria($materia);
        if ($resultado === 1) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'user_deleted'
            );
        } else {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'user_notdeleted'
            );
        }
        return $this->redirectToRoute('listMatter');
    }

    /**
     * @Route("/materias/seleccion/{materia}/{usuario}", name = "selectMateria")
     * @Security("has_role('ROLE_USER')")
     */
    public function selectAction(Request $request, Materia $materia, Usuario $usuario)
    {

        $resultado = 0;
        $horas = $this->getDoctrine()->getRepository(Usuario::class)->getHorasAsignadas($usuario);
        $configuracion = $this->getDoctrine()->getRepository(Configuracion::class)->encontrarConfiguracion();
        $turno = 0;
        $um = new Usuario_Materia();
        //Devuelve los usuario_materia del usuario  para el curso seleccionado ordenado por prioridad de menor a mayor
        $ultima = $this->getDoctrine()->getRepository(Usuario_Materia::class)->encontrarUltima($usuario,$configuracion);
        //Si no devuelve ninguno (NULL) Entonces será la primera.
        if ($ultima[0] === null){
            $turno = $usuario->getPrioridad();
        } else {
            //Tiene al menos 1 asignada
            $c = $this->getDoctrine()->getRepository(Usuario::class)->encontrarUltimo($usuario->getDepartamento());
            $c = $c->getPrioridad();
            //Toca buscar cual es...
            for ($k = 0; $k < count($ultima); $k++) {
                if (($ultima[$k]->getTurno() != ($usuario->getPrioridad() + ($k * $c)))) {
                    $turno = $usuario->getPrioridad() + ($k * $c);
                    break;
                }
            }
            if ($turno === 0) {
                $turno = $usuario->getPrioridad() + (count($ultima) * $c);
            }

        }
        $horas += $materia->getHorasSemanales();
        if ($horas <= $configuracion->getHorasMax()) {
            $um->setUsuario($usuario)
                ->setTurno($turno)
                ->setCurso($configuracion->getCurso())
                ->setMateria($materia);
            $resultado = $this->getDoctrine()->getRepository(Usuario_Materia::class)->guardarUsuarioMateria($um);
        }else{
            $resultado = 0;
        }
        if (1 === $resultado) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'matter_select'
            );

        } else {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'matter_notselect'
            );
        }
        return $this->redirectToRoute('seleccion');

    }
}
