<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use CloudSource\PatoBundle\Entity\Paises;

/**
* Classe que gerencia o crud de paises
*/
class PaisesController extends Controller
{
    /**
     * Retorna as informações de um pais
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $id Identificação do pais a ser retornado
     * 
     * @return mixed[] array Dados do pais
     **/
    public function getAction($id)
    {
        //resposta
        $responseBody = null;
        $response = new Response();

        //sanitiza o id
        $id = (int) $id;

        //pega repositorio de dados
        $em = $this->getDoctrine()->getEntityManager();

        //busca pais
        if ($id > 0) {
            //busca pais
            $pais = $em->find('PatoBundle:Paises', $id);

            if ($pais instanceof Paises) {
                $response->setStatusCode(200);
                $responseBody = array(
                    'id' => $pais->getId(),
                    'pais' => $pais->getPais()
                );
            }
            else {
                $response->setStatusCode(404);
                $responseBody = array(
                    'erro' => 'País não existe.'
                );
            }
        } else {
            $response->setStatusCode(400);
            $responseBody = array(
                'erro' => 'Requisição inválida.'
            );
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($responseBody));

        return $response;
    }

    /**
     * Salva um pais
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param mixed[] json $dados Dados do país a ser cadastrado
     *
     * @return mixed[] json Id e nome do país cadastrado
     **/
    function postAction()
    {
        //corpo resposta
        $responseBody = null;
        //resposta
        $response = new Response();
        
        //pega dados do post
        $post = $this->getRequest()->request->all();

        //sanitiza dados
        $post = array_map('addslashes', $post);

        //verifica se esta sendo passado a chave necessaria
        if(array_key_exists('pais', $post)) {

            //pega entity manager (gerenciador de entidades)
            $em = $this->getDoctrine()->getEntityManager();

            //novo pais
            $pais = new Paises();
            $pais->setPais($post['pais']);

            try {
                //salva
                $em->persist($pais);
                $em->flush();

                //define cod resposta
                $post['id'] = $pais->getId();
                $response->setStatusCode(201);
                $responseBody = $post;
            } catch (\Doctrine\DBAL\DBALException $e) {
                //define resposta
                $response->setStatusCode(409);
                $responseBody = array(
                    'erro' => 'Pais já existe.'
                );
            }
        } else {
            //define cod resposta
            $responseBody = array(
                'erro' => 'Requisição inválida.'
            );
            $response->setStatusCode(400);
        }

        //resposta
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($responseBody));

        return $response;
    }
}