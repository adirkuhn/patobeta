<?php

namespace AdirKuhn\PatoCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Home Page Controller
     *
     * @return \Symfony\Component\HttpFoundation\Response HomePage
     */
    public function indexAction()
    {
        return $this->render('PatoCoreBundle:Default:index.html.twig');
    }
}
