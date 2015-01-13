<?php

namespace AdirKuhn\ClientsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AdirKuhn\ClientsBundle\Entity\Company;
use AdirKuhn\ClientsBundle\Form\CompanyType;

/**
 * Company controller.
 *
 */
class CompanyController extends Controller
{

    /**
     * Lists all Company entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ClientsBundle:Company')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->query->get('page', 1) /*page number*/,
            50 /*limit per page*/
        );

        return $this->render('ClientsBundle:Company:index.html.twig', array(
            'pagination' => $pagination
        ));
    }
    /**
     * Creates a new Company entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Company();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('clients_company_show', array('id' => $entity->getId())));
        }

        return $this->render('ClientsBundle:Company:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Company entity.
     *
     * @param Company $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Company $entity)
    {
        $form = $this->createForm(new CompanyType(), $entity, array(
            'action' => $this->generateUrl('clients_company_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Company entity.
     *
     */
    public function newAction()
    {
        $entity = new Company();
        $form   = $this->createCreateForm($entity);

        return $this->render('ClientsBundle:Company:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Company entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClientsBundle:Company')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Company entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClientsBundle:Company:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Company entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClientsBundle:Company')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Company entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClientsBundle:Company:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Company entity.
    *
    * @param Company $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Company $entity)
    {
        $form = $this->createForm(new CompanyType(), $entity, array(
            'action' => $this->generateUrl('clients_company_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Company entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClientsBundle:Company')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Company entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $successUpdated = false;
        if ($editForm->isValid()) {
            $em->flush();
            $successUpdated = true;
            //return $this->redirect($this->generateUrl('clients_company_edit', array('id' => $id)));
        }

        return $this->render('ClientsBundle:Company:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'successUpdated' => $successUpdated
        ));
    }
    /**
     * Deletes a Company entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ClientsBundle:Company')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Company entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('clients_company'));
    }

    /**
     * Creates a form to delete a Company entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clients_company_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
