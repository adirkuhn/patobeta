<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use CloudSource\PatoBundle\Entity\Estados;
use CloudSource\PatoBundle\Entity\Paises;

/**
* Classe que gerencia o crud de estados
*/
class EstadosController extends Controller
{
    /**
     * Retorna as informações de um estado
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $id Identificação do estado a ser retornado
     * 
     * @return mixed[] array Dados do estado
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

        //busca estado
        if ($id > 0) {
            $estado = $em->find('PatoBundle:Estados', $id);

            if ($estado instanceof Estados) {
                $response->setStatusCode(200);
                $responseBody = array(
                    'id' => $estado->getId(),
                    'estado' => $estado->getEstado(),
                    'pais' => $estado->getPais()->getPais()
                );
            }
            else {
                $response->setStatusCode(404);
                $responseBody = array(
                    'erro' => 'Estado não existe.'
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
     * Salva um estado
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param mixed[] json $dados Dados do estado a ser cadastrado
     *
     * @return mixed[] json Id e nome do estado cadastrado
     **/
    function postAction()
    {
        //resposta
        $responseBody = null;
        $response = new Response();
        
        //pega dados do post e sanitiza
        $post = array_map('addslashes', $this->getRequest()->request->all());

        //verifica se esta sendo passado a chave necessaria
        if(array_key_exists('estado', $post) && array_key_exists('pais', $post)) {

            //pega entity manager (gerenciador de entidades)
            $em = $this->getDoctrine()->getEntityManager();

            //busca pais
            $pais = null;
            $pais = $em->find('PatoBundle:Paises', $post['pais']);

            if ($pais instanceof Paises) {
                //novo estado
                $estado = new Estados();
                $estado->setEstado($post['estado']);

                //seta pais
                $estado->setPais($pais);

                try {
                    //salva
                    $em->persist($estado);
                    $em->flush();

                    //define resposta
                    $post['id'] = $estado->getId();
                    $response->setStatusCode(201);
                    $responseBody = $post;

                } catch (\Doctrine\DBAL\DBALException $e) {
                    //define resposta
                    $response->setStatusCode(409);
                    $responseBody = array(
                        'erro' => 'Estado já existe.'
                    );
                }
            } else {
                //erro pais nao encontrado
                $responseBody = array(
                    'erro' => 'País não encontrado.'
                );
                $response->setStatusCode(400);
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

    /**
     * Retorna todos os estados de um determinado pais
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param $pais int Identificação do pais
     * 
     * @return mixed json Lista de estados
     **/
    function estadosPorPaisAction($pais)
    {
        //resposta
        $responseBody = null;
        $response = new Response();

        //sanitiza o id do pais
        $pais = (int) $pais;

        //pega repositorio de dados
        $em = $this->getDoctrine()->getEntityManager();

        //busca estados
        if ($pais > 0) {
            $estados = $em->getRepository('PatoBundle:Estados')->findBy(
                array('pais' => 1)
            );

            //se a consulta nao retornar vazia
            if (!empty($estados)) {
                $response->setStatusCode(200);

                foreach ($estados as $estado) {
                    $responseBody[] = array(
                        'id' => $estado->getId(),
                        'estado' => $estado->getEstado(),
                        'pais' => $pais
                    );
                }
            }
            else {
                $response->setStatusCode(404);
                $responseBody = array(
                    'erro' => 'Nenhum estado encontrado.'
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
}