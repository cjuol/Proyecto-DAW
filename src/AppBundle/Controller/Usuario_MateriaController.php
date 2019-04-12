<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Materia;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Usuario_Materia;
use AppBundle\Form\Model\Priority;
use AppBundle\Form\Type\PriorityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Usuario_MateriaController extends Controller
{

    /**
     * @Route("/usuario_materia/seleccion/{materia}/{usuario}", name = "selectUsuario_Materia")
     * @Security("has_role('ROLE_USER')")
     */
    public function selectAction(Materia $materia, Usuario $usuario, \Swift_Mailer $mailer)
    {
        $resultado= 0;
        // Devuelve el usuario_materia seleccionado.
        $usuario_Materia = $this->getDoctrine()->getRepository(Usuario_Materia::class)->encontrarUsuarioMateria($usuario, $materia);
        // Ya tenemos la configuración actual
        $configuracion = $this->getDoctrine()->getRepository(Configuracion::class)->encontrarConfiguracion();
        // Y la prioridad del ultimo usuario del departamento
        $c = $this->getDoctrine()->getRepository(Usuario::class)->encontrarUltimo($this->getUser()->getDepartamento());
        $c = $c->getPrioridad();

        // Añadimos el turno  que tiene el usuario_materia que va a cambiar de usuario
        $turno = $usuario_Materia->getTurno();
        // Eliminamos el usuario_materia del usuario antiguo
        $usuario->removeUsuarioMateria($usuario_Materia);
        // Y en caso de tener usuario_materia con el turno >  que el que tenia asignado el usuario_materia eliminado
        // le bajamos el turno en 1 para ajustar  la prioridad
        foreach ($usuario->getUsuarioMateria() as $um) {
            if ($um->getTurno() > $turno) {
                $um->setTurno($um->getTurno() - $c);
                $this->getDoctrine()->getRepository(Usuario_Materia::class)->guardarUsuarioMateria($um);
            }
        }
        $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuario);
        // Ya hemos eliminado el usuario_materia del usuario anterior ahora toca grabarlo de nuevo
        $ultima = $this->getDoctrine()->getRepository(Usuario_Materia::class)->encontrarUltima($this->getUser(), $configuracion);
        if ($ultima[0] === null) {
            $turno = $this->getUser()->getPrioridad();
        } else {
            for ($k = 0; $k < count($ultima); $k++) {
                if (($ultima[$k]->getTurno() != ($this->getUser()->getPrioridad() + ($k * $c)))) {
                    $turno = $this->getUser()->getPrioridad() + ($k * $c);
                    break;
                }
            }
            if ($turno === 0) {
                $turno = $this->getUser()->getPrioridad() + (count($ultima) * $c);
            }

        }
        $usuario_Materia->setUsuario($this->getUser())
            ->setTurno($turno);
        $resultado = $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($this->getUser());
        $resultado =$this->getDoctrine()->getRepository(Usuario_Materia::class)->guardarUsuarioMateria($usuario_Materia);

        //------------------------------------------------------------------------------
        $mailBody = $this->renderView('@App/Mails/matterChange.html.twig', [
            'newUser' => $this->getUser(),
            'oldUser' => $usuario,
            'matter' => $materia
        ]);
        $message = (new \Swift_Message('Prueba Proyecto'))
            ->setFrom($this->getParameter('mailer_user'))
            ->setTo($usuario->getCorreo(), $usuario->getNombre())
            ->setBody(
                $mailBody,
                'text/html'
            );

        $mailer->send($message);
        //-----------------------------------------------------------------------------------
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

    /**
     * @Route("/usuario_materia/desSeleccion/{materia}/{usuario}", name = "desSelectUsuario_Materia")
     * @Security("has_role('ROLE_USER')")
     */
    public function desSelectAction(Materia $materia, Usuario $usuario, \Swift_Mailer $mailer)
    {
        $um = $this->getDoctrine()->getRepository(Usuario_Materia::class)->encontrarUsuarioMateria($usuario, $materia);
        $resultado = $this->getDoctrine()->getRepository(Usuario_Materia::class)->borrarUsuarioMateria($um);
        if (1 === $resultado) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'matter_deselect'
            );

            $mailBody = $this->renderView('@App/Mails/deleteUM.html.twig', [
                'usuario'=> $um->getUsuario(),
                'materia'=> $um->getMateria()
            ]);
            $message = (new \Swift_Message('Prueba Proyecto'))
                ->setFrom($this->getParameter('mailer_user'));
            $mailU = $this->getDoctrine()->getRepository(Usuario::class)->encontrarTodosUsuariosDepartamento($um->getUsuario());
            foreach ($mailU as $u) {
                $message->addBcc($u->getCorreo(), $u->getNombre());
            }
            $message->setBody(
                $mailBody,
                'text/html'
            );

            $mailer->send($message);

        } else {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'matter_notdeselect'
            );
        }
        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/usuario_materia/prioridad/{materia}/{usuario}", name = "prioridadUsuario_materia")
     * @Security("has_role('ROLE_USER')")
     */
    public function changepriorityAction(Request $request, Materia $materia, Usuario $usuario, \Swift_Mailer $mailer)
    {
        $resultado = 0;
        $um = $this->getDoctrine()->getRepository(Usuario_Materia::class)->encontrarUsuarioMateria($usuario, $materia);
        $config = $this->getDoctrine()->getRepository(Configuracion::class)->encontrarConfiguracion();
        //-------------Por ahora no me vale la UM----------------
        $c = $this->getDoctrine()->getRepository(Usuario::class)->encontrarUltimo($usuario->getDepartamento());
        $c = $c->getPrioridad();
        $prior = new Priority();
        $form = $this->createForm(PriorityType::class, $prior, array('uPrioridad' => $usuario->getPrioridad(), 'turno' => $c));
        $form->handleRequest($request);
        if ($form->isValid() and $form->isSubmitted()){
            if ($um->getTurno() != $prior->getPrioridad()){
                $u = $this->getDoctrine()->getRepository(Usuario_Materia::class)->encontrarPrioridad($usuario, $prior->getPrioridad(), $config);
                if ($u === null){
                    $um->setTurno($prior->getPrioridad());
                    $resultado = $this->getDoctrine()->getRepository(Usuario_Materia::class)->guardarUsuarioMateria($um);
                }else{
                    $u->setTurno($um->getTurno());
                    $um->setTurno($prior->getPrioridad());
                    $resultado = $this->getDoctrine()->getRepository(Usuario_Materia::class)->guardarUsuarioMateria($um);
                    $resultado = $this->getDoctrine()->getRepository(Usuario_Materia::class)->guardarUsuarioMateria($u);
                }
            }
            if (1 === $resultado) {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'matter_prioritychange'
                );

                $mailBody = $this->renderView('@App/Mails/changepriority.html.twig', [
                    'usuario'=> $um->getUsuario(),
                    'materia'=> $um->getMateria(),
                    'turno'=> $um->getTurno()
                ]);
                $message = (new \Swift_Message('Prueba Proyecto'))
                    ->setFrom($this->getParameter('mailer_user'));
                $mailU = $this->getDoctrine()->getRepository(Usuario::class)->encontrarTodosUsuariosDepartamento($this->getUser());
                foreach ($mailU as $u) {
                    $message->addBcc($u->getCorreo(), $u->getNombre());
                }
                $message->setBody(
                    $mailBody,
                    'text/html'
                );

                $mailer->send($message);

            } else {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'matter_notprioritychange'
                );
            }
            return $this->redirectToRoute('homepage');
        }


        return $this->render('@App/matter/changePriority.twig', array(
            'form' => $form->createView()
        ));
    }
}
