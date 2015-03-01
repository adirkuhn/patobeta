<?php

namespace AdirKuhn\CashFlowBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AdirKuhn\CashFlowBundle\Entity\CashFlowItem;
use AdirKuhn\CashFlowBundle\Form\CashFlowItemType;

/**
 * CashFlowItem controller.
 *
 */
class CashFlowItemController extends Controller
{

    /**
     * Lists all CashFlowItem entities.
     *
     */
    public function indexAction(Request $request, $selectedMonth, $selectedYear)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_READ'))) {
            throw $this->createAccessDeniedException();
        }

        $dates['actualYear'] = date('Y');
        $dates['actualMonth'] = date('m');

        //selected year via get
        if ($selectedYear  != 0) {
            $dates['selectedYear'] = $selectedYear;
        }
        else {
            $dates['selectedYear'] = $dates['actualYear'];
        }

        //selected month via get
        if ($selectedMonth != 0) {
            $dates['selectedMonth'] = $selectedMonth;
        }
        else {
            $dates['selectedMonth'] = $dates['actualMonth'];
        }

        $postDates = $request->request->all();
        if(!empty($postDates)) {

            if(isset($postDates['selectedMonth'])) {
                $dates['selectedMonth'] = $postDates['selectedMonth'];
            }
            if(isset($postDates['selectedYear'])) {
                $dates['selectedYear'] = $postDates['selectedYear'];
            }
        }

        $em = $this->getDoctrine()->getManager();

        //List CashFlowItem + Accounts
        $repository = $em->getRepository('CashFlowBundle:CashFlowItem');
        $entities = $repository->findAllCashFlow($dates['selectedYear'], $dates['selectedMonth']);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->query->get('page', 1) /*page number*/,
            50 /*limit per page*/
        );

        //get all year that have accounts
        $yearsWithAccounts = $repository->getCashFlowYearsWithAllAccounts();

        //get balance
        $balance = $repository->getBalance($dates['selectedYear'], $dates['selectedMonth']);

        return $this->render('CashFlowBundle:CashFlowItem:index.html.twig', array(
            'pagination' => $pagination,
            'yearsWithAccounts' => $yearsWithAccounts,
            'dates' => $dates,
            'balance' => $balance[0]
        ));
    }
    /**
     * Creates a new CashFlowItem entity.
     *
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_WRITE'))) {
            throw $this->createAccessDeniedException();
        }

        $entity = new CashFlowItem();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $entity->setPaidAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cashflowitem_show', array('id' => $entity->getId())));
        }

        return $this->render('CashFlowBundle:CashFlowItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CashFlowItem entity.
     *
     * @param CashFlowItem $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CashFlowItem $entity)
    {
        $form = $this->createForm(new CashFlowItemType(), $entity, array(
            'action' => $this->generateUrl('cashflowitem_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CashFlowItem entity.
     *
     */
    public function newAction($type)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_WRITE'))) {
            throw $this->createAccessDeniedException();
        }

        $entity = new CashFlowItem();

        if (!in_array($type, $entity::$types)) {
            return $this->redirect($this->generateUrl('cashflowitem'));
        }
        //set type
        $entity->setType($type);
        $form   = $this->createCreateForm($entity);

        return $this->render('CashFlowBundle:CashFlowItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CashFlowItem entity.
     *
     */
    public function showAction($id)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_READ'))) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CashFlowBundle:CashFlowItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CashFlowItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $todayDate = new \DateTime('now');

        return $this->render('CashFlowBundle:CashFlowItem:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'todayDate' => $todayDate->format('Y-m-d'),
        ));
    }

    /**
     * Displays a form to edit an existing CashFlowItem entity.
     *
     */
    public function editAction($id)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_UPDATE'))) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CashFlowBundle:CashFlowItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CashFlowItem entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CashFlowBundle:CashFlowItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CashFlowItem entity.
    *
    * @param CashFlowItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CashFlowItem $entity)
    {
        $form = $this->createForm(new CashFlowItemType(), $entity, array(
            'action' => $this->generateUrl('cashflowitem_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CashFlowItem entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_UPDATE'))) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CashFlowBundle:CashFlowItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CashFlowItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $successUpdated = false;
        if ($editForm->isValid()) {
            $em->flush();
            $successUpdated = true;
        }

        return $this->render('CashFlowBundle:CashFlowItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'successUpdated' => $successUpdated
        ));
    }
    /**
     * Deletes a CashFlowItem entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_DELETE'))) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CashFlowBundle:CashFlowItem')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CashFlowItem entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cashflowitem'));
    }

    /**
     * Creates a form to delete a CashFlowItem entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cashflowitem_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
