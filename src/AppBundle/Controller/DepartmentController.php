<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Departamento;
use AppBundle\Form\Type\NewDepartmentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DepartmentController extends Controller
{

    /**
     * @Route("/departamentos/", name = "listDepartments")
     * @Security("has_role('ROLE_USER')")
     */
    public  function indexAction(){
        $departamento = $this->getDoctrine()->getRepository(Departamento::class)->encontrarTodosDepartamentos($this->getUser());
        return $this->render('@App/department/index.html.twig', array(
            'departamentos' => $departamento,
        ));

    }
    /**
     * @Route("/departamentos/eliminar/{departamento}", name = "deleteDepartment", methods={"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteDepartmentAction(Request $request, Departamento $departamento)
    {

            $resultado = $this->getDoctrine()->getRepository(Departamento::class)->borrarDepartamento($departamento);
            if (1 === $resultado) {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'department_added'
                );
            } else {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'department_notadded'
                );
            }

        return $this->redirectToRoute('listDepartments');
    }

    /**
     * @Route("/departamentos/nuevo", name = "newDepartment")
     * @Security("has_role('ROLE_DEPARTMENT')")
     */
    public function newDepartmentAction(Request $request)
    {
        $departamento = new Departamento();
        $form = $this->createForm(NewDepartmentType::class, $departamento);
        $form->handleRequest($request);
        if ($form->isSubmitted()){

            if ($form->isValid()) {
                $resultado = $this->getDoctrine()->getRepository(Departamento::class)->guardarDepartamento($departamento);
                if (1 === $resultado) {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'department_added'
                    );
                } else {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'department_notadded'
                    );
                }
                return $this->redirectToRoute('listDepartments');
            }else {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'department_notadded'
                );
                return $this->redirectToRoute('newDepartment');
            }
        }
        return $this->render('AppBundle:department:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/departamentos/detalle/department={id}", name = "profileDepartment")
     * @Security("has_role('ROLE_USER')")
     */
    public function profileAction(Request $request, Departamento $departamento = null)
    {
        $form = $this->createForm(NewDepartmentType::class, $departamento);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if ($form->isValid()) {
                $resultado = $this->getDoctrine()->getRepository(Departamento::class)->guardarDepartamento($departamento);
                if (1 === $resultado) {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'department_edited'
                    );
                } else {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'department_notedited'
                    );
                }
                return $this->redirectToRoute('profileDepartment', array('id' => $departamento->getId()));
            }else {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'department_notedited'
                );
                return $this->redirectToRoute('profileDepartment', array('id' => $departamento->getId()));
            }
        }
        return $this->render('@App/department/profile.html.twig', array(
            'form' => $form->createView(),
            'departamento' => $departamento
        ));
    }
}
