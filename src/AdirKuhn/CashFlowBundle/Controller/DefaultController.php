<?php

namespace AdirKuhn\CashFlowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CASHFLOWBUNDLE_READ'))) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('CashFlowBundle:Default:index.html.twig');
    }
}
