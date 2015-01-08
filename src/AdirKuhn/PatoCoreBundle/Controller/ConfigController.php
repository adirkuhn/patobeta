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
        return $this->render('PatoCoreBundle:Config:index.html.twig');
    }
}