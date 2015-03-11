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
        $entities = $this->getDoctrine()->getRepository('ClientsBundle:Contact')->findRecentContacts();

        return $this->render('PatoCoreBundle:Default:index.html.twig', array('entities' => $entities));
    }
}
