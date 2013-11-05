<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use CloudSource\PatoBundle\Entity\CaixasMovimentosTipos;


/**
 *
 * Classe gerenciar tipos de movimento
 **/
class CaixasMovimentosTiposController extends Controller
{
    /**
     * Função de ajuda para resposta rest json
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param mixed $corpo Corpo da resposta
     * @param int $httpCode Código da resposta HTTP
     * 
     * @return Response Resposta a ser enviada
     **/
    public function resposta($corpo, $httpCode = 200)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($httpCode);
        $response->setContent(json_encode($corpo));

        return $response;
    }

    /**
     * Retorna os tipos de movimentos
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param String $tipoMovimento Tipo de movimento a ser retornado 'entrada' ou 'saida' caso não seja especificado o tipo retorna todos os tipos de movimentos
     *
     * @return mixed JSON com os tipos de movimentos
     **/
    public function tiposMovimentoAction($tipoMovimento = 'todos')
    {

        $em = $this->getDoctrine()->getRepository('PatoBundle:CaixasMovimentosTipos');

        if ($tipoMovimento === 'todos') {
            $tipos = $em->findAll();
        }
        elseif ($tipoMovimento === 'entrada') {
            $tipos = $em->findByTipo(1);
        }
        elseif ($tipoMovimento === 'saida') {
            $tipos = $em->findByTipo(0);
        }
        else {

            return $this->resposta('Requisição inválida', 400);
        }

        $resposta = array();
        foreach ($tipos as $tipo) {
            $resposta[] = array(
                'id' => $tipo->getId(),
                'movimentoTipo' => $tipo->getMovimentoTipo(),
                'descricao' => $tipo->getDescricao(),
            );
        }

        return $this->resposta($resposta);

    }
}