<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracaoController extends Controller
{

    /**
     * Página inicial de configuração do sistema
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     *
     * @return Página inicial de configuração do sistema
     **/
    public function indexAction()
    {
        return $this->render('PatoBundle:Configuracao:index.html.twig');
    }
}