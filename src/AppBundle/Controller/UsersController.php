<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Model\ChangePassword;
use AppBundle\Form\Type\ChangePasswordType;
use AppBundle\Form\Type\EditUserType;
use AppBundle\Form\Type\NewUserType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{

    /**
     * @Route("/usuarios/", name = "listUsers")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexUsuariosAction()
    {
        $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->encontrarTodosUsuarios($this->getUser());
        $porcentajesMaterias = new ArrayCollection();
        $porcentajesExenciones = new ArrayCollection();

        foreach ($usuarios as $u) {
            $porcentajesMaterias [] = $this->getDoctrine()->getRepository(Usuario::class)->getPorcentajeMateriasAsignadas($u);
            $porcentajesExenciones [] = $this->getDoctrine()->getRepository(Usuario::class)->getPorcentajeExencionesAsignadas($u);

        }
        return $this->render('@App/users/index.html.twig', [
            'usuarios' => $usuarios,
            'porcentajesMaterias' => $porcentajesMaterias,
            'porcentajesExenciones' => $porcentajesExenciones
        ]);
    }

    /**
     * @Route("/usuarios/nuevo", name = "newUser")
     * @Security("has_role('ROLE_DEPARTMENT')")
     */
    public function newUserAction(Request $request, \Swift_Mailer $mailer)
    {
        $usuario = new Usuario();
        $form = $this->createForm(NewUserType::class, $usuario, array('usuario' => $this->getUser()));
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($usuario);

            $usuario->setNombre(mb_convert_encoding(mb_convert_case($usuario->getNombre(), MB_CASE_TITLE), "UTF-8"));
            $usuario->setApellidos(mb_convert_encoding(mb_convert_case($usuario->getApellidos(), MB_CASE_TITLE), "UTF-8"));
            if (count($errors) > 0) {
                $errorsString = $errors;
            }

            if ($form->isValid()) {

                if ('Departamento' === $this->getUser()->getRol()->getNombre()) {
                    $usuario->setDepartamento($this->getUser()->getDepartamento());
                }
                $usuario->setHash(base64_encode(random_bytes(20)));
                $usuario->setIsHashActive(true);
                $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->encontrarPorPrioridad($usuario);
                if (count($usuarios) > 1) {
                    for ($k = 1; $k < count($usuarios); $k++) {
                        if ($usuarios[$k] == $usuario) {
                            $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuario);
                        } else {
                            if ($usuario->getPrioridad() == $usuarios[$k]->getPrioridad()) {
                                $usuarios[$k]->setPrioridad($usuarios[$k]->getPrioridad() + 1);
                                $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuarios[$k]);

                            }
                            if (count($usuarios) - 1 != $k) {
                                if ($usuarios[$k]->getPrioridad() != $usuarios[$k + 1]->getPrioridad()) {
                                    break;
                                }
                            }
                        }
                    }
                }
                $resultado = $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuario);
                if (1 === $resultado) {
                    //------------------------------------------------------------------

                    $mailBody = $this->renderView('@App/Mails/newUser.html.twig', [
                        'host' => $_SERVER['SERVER_NAME'],
                        'user' => $usuario,
                        'hash' => urlencode($usuario->getHash())
                    ]);
                    $message = (new \Swift_Message('Bienvenido ' . $usuario->getNombre()))
                        ->setFrom($this->getParameter('mailer_user'))
                        ->setTo($usuario->getCorreo(), $usuario->getNombre())
                        ->setBody(
                            $mailBody,
                            'text/html'
                        );

                    $mailer->send($message);
                    //------------------------------------------------------------------

                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'user_added'
                    );
                } else {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'user_notadded'
                    );
                }

                return $this->redirectToRoute('listUsers');
            }else{
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'user_notadded'
                );
            }


        }
        return $this->render('AppBundle:users:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/usuarios/perfil/user={id}", name = "profileUser")
     * @Security("is_granted('ROLE_USER')")
     */
    public function profileAction(Request $request, Usuario $usuario)
    {
        $pass = new ChangePassword();
        $passForm = $this->createForm(ChangePasswordType::class, $pass);
        $passForm->handleRequest($request);
        $form = $this->createForm(EditUserType::class, $usuario, array('usuario' => $this->getUser()));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $usuario->setNombre(mb_strtolower($usuario->getNombre()));
            $usuario->setApellidos(mb_strtolower($usuario->getApellidos()));
            $usuario->setNombre(mb_convert_encoding(mb_convert_case($usuario->getNombre(), MB_CASE_TITLE), "UTF-8"));
            $usuario->setApellidos(mb_convert_encoding(mb_convert_case($usuario->getApellidos(), MB_CASE_TITLE), "UTF-8"));

            $validator = $this->get('validator');
            $errors = $validator->validate($usuario);
            if (count($errors) > 0) {
                $errorsString = $errors;
            }

            if ($form->isValid()) {
                $resultado = $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuario);
                $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->encontrarPorPrioridad($usuario);
                if (count($usuarios) > 1) {
                    for ($k = 1; $k < count($usuarios); $k++) {
                        if ($usuarios[$k] == $usuario) {
                            $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuario);
                        } else {
                            if ($usuario->getPrioridad() == $usuarios[$k]->getPrioridad()) {
                                $usuarios[$k]->setPrioridad($usuarios[$k]->getPrioridad() + 1);
                                $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuarios[$k]);

                            }
                            if (count($usuarios) - 1 != $k) {
                                if ($usuarios[$k]->getPrioridad() != $usuarios[$k + 1]->getPrioridad()) {
                                    break;
                                }
                            }
                        }
                    }
                }
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
                return $this->redirectToRoute('profileUser', array('id' => $usuario->getId()));
            }else{
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'user_notedited'
                );
            }
            return $this->redirectToRoute('profileUser', array('id' => $usuario->getId()));
        }
        if ($passForm->isSubmitted()) {

            $validator = $this->get('validator');
            $errors = $validator->validate($pass);
            if (count($errors) > 0) {
                foreach ($errors as $e){
                    if ($e->getMessage() === "Password should by at least 6 chars long"){
                        $this->get('session')->getFlashBag()->add(
                            'notice',
                            'user_pass_length'
                        );
                    }if ($e->getMessage() === "Wrong value for your current password"){
                        $this->get('session')->getFlashBag()->add(
                            'notice',
                            'user_pass_wrong'
                        );
                    }
                }

            }

            if ($passForm->isValid()) {
                $encoder = $this->container->get('security.password_encoder');
                $password = $encoder->encodePassword($usuario, $pass->getNewPassword());
                $usuario->setClave($password);
                $resultado = $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuario);

                if (1 === $resultado) {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'user_pass_change'
                    );
                } else {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'user_pass_notchange'
                    );
                }
                return $this->redirectToRoute('profileUser', array('id' => $usuario->getId()));
            }else{
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'user_pass_notchange'
                );
            }
            return $this->redirectToRoute('profileUser', array('id' => $usuario->getId()));
        }
        return $this->render('@App/users/edit.html.twig', [
            'form' => $form->createView(),
            'passForm' => $passForm->createView(),
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/usuarios/perfil/borrar/user={id}", name = "deleteUser")
     * @Security("has_role('ROLE_DEPARTMENT')")
     */
    public function deleteAction(Usuario $usuario = null)
    {
        $resultado = $this->getDoctrine()->getRepository(Usuario::class)->borrarUsuario($usuario);
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
        return $this->redirectToRoute('listUsers');
    }
}
