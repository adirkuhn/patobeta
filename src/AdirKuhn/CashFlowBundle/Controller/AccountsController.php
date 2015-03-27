<?php

namespace AdirKuhn\CashFlowBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AdirKuhn\ClientsBundle\Entity\Company;
use AdirKuhn\CashFlowBundle\Entity\Accounts;
use AdirKuhn\CashFlowBundle\Form\AccountsType as AccountsType;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * Accounts controller (receivable).
 *
 */
class AccountsController extends Controller
{
    private $type = 0;

    /**
     * Lists all Accounts entities.
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

        //get entity manager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CashFlowBundle:Accounts');

        //get accounts
        $entities = $repository->getAccountsByYearAndMonth($this->type, $dates['selectedYear'], $dates['selectedMonth']);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->query->get('page', 1) /*page number*/,
            50 /*limit per page*/
        );

        //get sum accounts on this month/year
        $sumAccountsSelectedMonth = $repository->getSumAccountsByYearAndMonth($this->type, $dates['selectedYear'], $dates['selectedMonth']);
        $sumAccountsSelectedYear = $repository->getSumAccountsByYear($this->type, $dates['selectedYear']);

        //check overdue accounts
        $overdueAccounts = $repository->getOverdueAccounts($this->type);
        $sumOverdueAccount = $repository->getSumOverdueAccounts($this->type);

        //year with accounts to receive
        $yearsWithAccounts = $repository->getYearsWithAccounts();

        return $this->render('CashFlowBundle:Accounts:index.html.twig', array(
            'pagination' => $pagination,
            'yearsWithAccounts' => $yearsWithAccounts,
            'dates' => $dates,
            'overdueAccounts' => array(
                'entities' => $overdueAccounts,
                'sum' => $sumOverdueAccount
            ),
            'sumAccountsSelectedMonth' => $sumAccountsSelectedMonth,
                'sumAccountsSelectedYear' => $sumAccountsSelectedYear,
        ));
    }
    /**
     * Creates a new Accounts entity.
     *
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_WRITE'))) {
            throw $this->createAccessDeniedException();
        }

        $entity = new Accounts();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            //set paid
            if ($entity->getStatus() == 0) {
                $entity->setPaidAt(new \DateTime());
            }
            else {
                $entity->setPaidAt(null);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cashflow_accounts_receivable_show', array('id' => $entity->getId())));
        }

        return $this->render('CashFlowBundle:Accounts:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Accounts entity.
     *
     * @param Accounts $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Accounts $entity)
    {

        $form = $this->createForm(new AccountsType(), $entity, array(
            'action' => $this->generateUrl('cashflow_accounts_receivable_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Accounts entity.
     *
     */
    public function newAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_WRITE'))) {
            throw $this->createAccessDeniedException();
        }

        $entity = new Accounts();
        //set to receivable
        $entity->setType($this->type);

        $form   = $this->createCreateForm($entity);

        return $this->render('CashFlowBundle:Accounts:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Accounts entity.
     *
     */
    public function showAction($id)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_READ'))) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CashFlowBundle:Accounts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Accounts entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CashFlowBundle:Accounts:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Accounts entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_UPDATE'))) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CashFlowBundle:Accounts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Accounts entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $referer = $request->headers->get('referer');

        return $this->render('CashFlowBundle:Accounts:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'referer' => !empty($referer)? $referer:null,
        ));
    }

    /**
    * Creates a form to edit a Accounts entity.
    *
    * @param Accounts $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Accounts $entity)
    {
        $form = $this->createForm(new AccountsType(), $entity, array(
            'action' => $this->generateUrl('cashflow_accounts_receivable_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Accounts entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_UPDATE'))) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CashFlowBundle:Accounts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Accounts entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $successUpdated = false;
        if ($editForm->isValid()) {

            //set paid
            if ($entity->getStatus() == 0) {
                $entity->setPaidAt(new \DateTime());
            }
            else {
                $entity->setPaidAt(null);
            }

            $em->flush();

            $successUpdated = true;
            //return $this->redirect($this->generateUrl('cashflow_accounts_receivable_edit', array('id' => $id)));
        }

        return $this->render('CashFlowBundle:Accounts:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'successUpdated' => $successUpdated,
        ));
    }
    /**
     * Deletes a Accounts entity.
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
            $entity = $em->getRepository('CashFlowBundle:Accounts')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Accounts entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cashflow_accounts_receivable_home'));
    }

    /**
     * Creates a form to delete a Accounts entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cashflow_accounts_receivable_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Return account info
     *
     * @param int $type Type of accounts
     * @param int $id Account Id
     */
    public function infoAction($type, $id) {

        $entity = $this->getDoctrine()->getManager()->getRepository('CashFlowBundle:Accounts')->find($id);

        $normalizer = new GetSetMethodNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format(\DateTime::ISO8601)
                : '';
        };

        $callback2 = function($company) {
            return $companny instanceof Company
                ? $company->name
                : '';
        };

        $normalizer->setCallbacks(array(
            'createdAt' => $callback,
            'paidAt' => $callback,
            'dueDate' => $callback,
            'company' => $callback2,
        ));

        $return = $normalizer->normalize($entity);

        return new JsonResponse($return);
    }
}
