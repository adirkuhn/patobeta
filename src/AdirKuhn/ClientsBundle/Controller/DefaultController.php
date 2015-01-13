<?php

namespace AdirKuhn\ClientsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientsBundle:Default:index.html.twig');
    }
}
