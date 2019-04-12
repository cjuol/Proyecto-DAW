<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Notificacion;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Usuario_Materia;
use AppBundle\Form\Type\ConfigType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracionController extends Controller
{
    /**
     * Accion que muestra el ultimo registro de la entidad Configuracion junto con un formulario para permitir
     * la edición del registro y una serie de acciones.
     *
     * En caso de edicion del registro la accion creará un mensaje flash con el cual mostraremos un mensaje determinado
     * definido previamente en un objeto  javascript
     *
     * Esta accion solo es accesible para usuarios con role 'ROLE_ADMIN' para evitar que cualquier otro usuario realice
     * cambios  que puedan entorpecer el correcto funcionamiento de la aplicacion y la experiencia de los demas usuarios
     *
     * @Route("/configuracion", name = "listConfig")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $configuracion = $this->getDoctrine()->getRepository(Configuracion::class)->encontrarConfiguracion();
        $form = $this->createForm(ConfigType::class, $configuracion);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            /**
             * Cuando enviamos el formulario comprobamos si las horasMax son menores que las horasMin.
             * Si se da esta condición creamos un mensaje flash para informar al administrador  y realizamos una
             * redireccion a la misma accion para evitar guardar los nuevos datos.
             */
            if ($form->getData()->getHorasMin() > $form->getData()->getHorasMax()) {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'config_notedited'
                );
                return $this->redirectToRoute('listConfig');
            } elseif ($form->isValid()) {
                /**
                 * Despues de comprobar el rango de horas
                 */
                $resultado = $this->getDoctrine()->getRepository(Configuracion::class)->guardarConfiguracion($configuracion);
                if (1 === $resultado) {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'config_edited'
                    );
                } else {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'config_notedited'
                    );
                }
                return $this->redirectToRoute('listConfig');
            }
        }
        return $this->render('@App/config/index.html.twig', array(
            'form' => $form->createView(),
            'configuracion' => $configuracion
        ));
    }


    /**
     * @Route("/configuracion/iniciar", name = "iniConfig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function iniciarApp(\Swift_Mailer $mailer)
    {
        $usuario = $this->getDoctrine()->getRepository(Usuario::class)->encontrarTodosUsuarios($this->getUser());
        $mailBody = $this->renderView('@App/Mails/ini.html.twig', []);
        $message = (new \Swift_Message('Prueba Proyecto'))
            ->setFrom($this->getParameter('mailer_user'));

        foreach ($usuario as $u) {
            foreach ($u->getUsuarioMateria() as $m) {
                $this->getDoctrine()->getRepository(Usuario_Materia::class)->borrarUsuarioMateria($m);
            }
            foreach ($u->getExencion() as $ex) {
                $u->removeExencion($ex);
            }
            $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($u);
            $message->addBcc($u->getCorreo(), $u->getNombre());
        }

        $message->setBody(
            $mailBody,
            'text/html'
        );

        $mailer->send($message);
        return $this->redirectToRoute('listConfig');
    }
}
