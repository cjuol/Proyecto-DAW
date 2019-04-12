<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Exencion;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\NewExencionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExencionController extends Controller
{

    /**
     * @Route("/exencion/detalle/borrar/user={id}", name = "deleteExencion")
     * @Security("has_role('ROLE_DEPARTMENT')")
     */
    public function deleteAction(Exencion $exencion)
    {
        $resultado = $this->getDoctrine()->getRepository(Exencion::class)->borrarExencion($exencion);
        if ($resultado === 1) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'user_deleted'
            );
        }else{
            $this->get('session')->getFlashBag()->add(
                'notice',
                'user_notdeleted'
            );
        }
        return $this->redirectToRoute('listExencion');
    }

    /**
     * @Route("/exencion/", name = "listExencion")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        $exenciones = $this->getDoctrine()->getRepository(Exencion::class)->encontrarExenciones();
        return $this->render('@App/exencion/index.html.twig', [
            'exenciones' => $exenciones
        ]);
    }

    /**
     * @Route("/exencion/nueva", name = "newExecion")
     * @Route("/exencion/modificar/{id}", name = "modExecion")
     * @Security("has_role('ROLE_DEPARTMENT')")
     */
    public function newMatterAction(Request $request)
    {
        $execion = new Exencion();
        $form = $this->createForm(NewExencionType::class, $execion);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if ($execion->getHorasSemanales() >= $execion->getHorasTotales()){
                $this->get('session')->getFlashBag()->add('notice',
                    'execion_notadded'
                );
                return $this->redirectToRoute('newExecion');
            }
            if ($form->isValid()) {
                $resultado = $this->getDoctrine()->getRepository(Exencion::class)->guardarExencion($execion);
                if (1 === $resultado) {
                    $this->get('session')->getFlashBag()->add('notice',
                        'execion_added');
                } else {
                    $this->get('session')->getFlashBag()->add('notice',
                        'execion_notadded'
                    );
                }
                return $this->redirectToRoute('listExencion');
            }else {
                $this->get('session')->getFlashBag()->add('notice',
                    'execion_notadded'
                );
                return $this->redirectToRoute('newExecion');

            }
        }
        return $this->render('AppBundle:exencion:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/exenciones/detalle/{id}", name = "profileExencion")
     * @Security("has_role('ROLE_USER')")
     */
    public function profileAction(Request $request, Exencion $exencion)
    {
        $form = $this->createForm(NewExencionType::class, $exencion);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if ($exencion->getHorasSemanales() >= $exencion->getHorasTotales()) {
                $this->get('session')->getFlashBag()->add('notice',
                    'execion_notedited'
                );
                return $this->redirectToRoute('profileExencion', array('id' => $exencion->getId()));
            }
            if ($form->isValid()) {
                $resultado = $this->getDoctrine()->getRepository(Exencion::class)->guardarExencion($exencion);
                if (1 === $resultado) {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'execion_edited'
                    );

                } else {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'execion_notedited'
                    );
                }
                return $this->redirectToRoute('profileExencion', array('id' => $exencion->getId()));
            }else {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'execion_notedited'
                );
                return $this->redirectToRoute('profileExencion', array('id' => $exencion->getId()));

            }
        }
        return $this->render('@App/exencion/profile.html.twig', [
            'form' => $form->createView(),
            'materia' => $exencion
        ]);
    }

    /**
     * @Route("/exencion/asignar/{usuario}", name = "asignarExencion")
     * @Security("has_role('ROLE_USER')")
     */
    public function asignarAction(Usuario $usuario)
    {
        $exenciones = $this->getDoctrine()->getRepository(Exencion::class)->encontrarExenciones();
        return $this->render('@App/exencion/asignacion.html.twig', [
            'usuario' => $usuario,
            'exenciones' => $exenciones
        ]);
    }

    /**
     * @Route("/exenciones/seleccion/{exencion}/{usuario}", name = "selectExencion")
     * @Security("has_role('ROLE_USER')")
     */
    public function selectAction(Request $request, Exencion $exencion, Usuario $usuario)
    {
        $resultado = 0;
        if (!$exencion->getUsuarios()->contains($usuario)) {
            $exencion->addUsuarios($usuario);
            $resultado = $this->getDoctrine()->getRepository(Exencion::class)->guardarExencion($exencion);
        }
        if (1 === $resultado) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'exencion_select'
            );

        } else {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'exencion_notselect'
            );
        }
        return $this->redirectToRoute('seleccion');

    }

    /**
     * @Route("/exenciones/desSeleccion/{exencion}/{usuario}", name = "desSelectExencion")
     * @Security("has_role('ROLE_USER')")
     */
    public function desSelectAction(Request $request, Exencion $exencion, Usuario $usuario)
    {
        $resultado = 0;
        $usuario->removeExencion($exencion);
        $exencion->removeUsuarios($usuario);

        $resultado = $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuario);
        $resultado = $this->getDoctrine()->getRepository(Exencion::class)->guardarExencion($exencion);
        if (1 === $resultado) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'exencion_deselect'
            );

        } else {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'exencion_notdeselect'
            );
        }
        return $this->redirectToRoute('homepage');

    }

}
