<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Model\resetPassword;
use AppBundle\Form\Type\resetPasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends Controller
{

    /**
     * @Route("/login", name = "login")
     */
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();

        if(!is_null($error)){
            if('Authentication request could not be processed due to a system problem.' === $error->getMessageKey()){
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'login_server'
                );
            }

            if('Invalid credentials.' === $error->getMessageKey()){
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'login_credentials'
                );
            }
        }

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('@App/security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error
        ));
    }

    /**
     * @Route("/comprobar", name = "login_check")
     * @Route("/salir", name = "logout")
     */
    public function logInOutCheckAction()
    {
    }


    /**
     * @Route("/reset/{hash}", name = "resetPass")
     */
    public function changePasswordAction(Request $request, $hash)
    {
        $hash = urldecode($hash);
        $usuario = $this->getDoctrine()->getRepository(Usuario::class)->encontrarHash($hash);
        if ($usuario === null){
            return $this->redirectToRoute('login');
        }
        $pass = new resetPassword();
        $passForm = $this->createForm(resetPasswordType::class, $pass);
        $passForm->handleRequest($request);
        if ($passForm->isSubmitted() && $passForm->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $pass = $encoder->encodePassword($usuario, $pass->getNewPassword());
            $usuario->setClave($pass);
            $usuario->setIsHashActive(false);
            $resultado = $this->getDoctrine()->getRepository(Usuario::class)->guardarUsuario($usuario);
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
            return $this->redirectToRoute('login');
        }
        return $this->render('@App/security/reset.html.twig', array(
            'form' => $passForm->createView()
        ));
    }

}
