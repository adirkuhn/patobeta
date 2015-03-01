<?php

namespace AdirKuhn\ClientsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_CLIENTSBUNDLE_READ'))) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('ClientsBundle:Default:index.html.twig');
    }
}
