<?php
namespace AdirKuhn\PatoCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigController extends Controller
{

    /**
     * Configuration page
     *
     */
    public function indexAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('PatoCoreBundle:Config:index.html.twig');
    }
}