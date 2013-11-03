<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use CloudSource\PatoBundle\Entity\Cidades;
use CloudSource\PatoBundle\Entity\Estados;

/**
* Classe que gerencia o crud de cidades
*/
class CidadesController extends Controller
{
    /**
     * Retorna as informações de uma cidade
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $id Identificação da cidade a ser retornado
     * 
     * @return mixed[] array Dados da cidade
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

        //busca cidade
        if ($id > 0) {
            $cidade = $em->find('PatoBundle:Cidades', $id);

            if ($cidade instanceof Cidades) {
                $response->setStatusCode(200);
                $responseBody = array(
                    'id' => $cidade->getId(),
                    'cidade' => $cidade->getCidade(),
                    'estado' => array(
                        'id' => $cidade->getEstado()->getId(),
                        'estado' => $cidade->getEstado()->getEstado()
                    ),
                );
            }
            else {
                $response->setStatusCode(404);
                $responseBody = array(
                    'erro' => 'Cidade não existe.'
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
     * Salva uma cidade
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param mixed[] json $dados Dados da cidade a ser cadastrado
     *
     * @return mixed[] json Informações da cidade cadastrada
     **/
    function postAction()
    {
        //resposta
        $responseBody = null;
        $response = new Response();
        
        //pega dados do post e sanitiza
        $post = array_map('addslashes', $this->getRequest()->request->all());

        //verifica se esta sendo passado a chave necessaria
        if(array_key_exists('cidade', $post) && array_key_exists('estado', $post)) {

            //pega entity manager (gerenciador de entidades)
            $em = $this->getDoctrine()->getEntityManager();

            //busca estado
            $estado = null;
            $estado = $em->find('PatoBundle:Estados', $post['estado']);

            //Verifica se o estado é valido para poder continuar com o cadastro de cidade
            if ($estado instanceof Estados) {
                //nova cidade
                $cidade = new Cidades();
                $cidade->setCidade($post['cidade']);

                //seta estado
                $cidade->setEstado($estado);

                try {
                    //salva
                    $em->persist($cidade);
                    $em->flush();

                    //define resposta
                    $post['id'] = $cidade->getId();
                    $response->setStatusCode(201);
                    $responseBody = $post;

                } catch (\Doctrine\DBAL\DBALException $e) {
                    //define resposta
                    $response->setStatusCode(409);
                    $responseBody = array(
                        'erro' => 'Cidade já existe.'
                    );
                }
            } else {
                //erro estado nao encontrado
                $responseBody = array(
                    'erro' => 'Estado não encontrado.'
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
     * Retorna lista de cidades de um determinado estado
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $estado Identificação do estado
     * 
     * @return mixed[] json Lista de cidades
     **/
    public function cidadesPorEstadoAction($estado)
    {
        //resposta
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $responseBody = null;

        //sanitiza o id do estado
        $estado = (int) $estado;

        //pega repositorio de dados
        $em = $this->getDoctrine()->getEntityManager();

        //busca cidades
        if ($estado > 0) {
            $cidades = $em->getRepository('PatoBundle:Cidades')->findBy(
                array('estado' => $estado)
            );

            //se a consulta nao retornar vazia
            if (!empty($cidades)) {
                $response->setStatusCode(200);

                foreach ($cidades as $cidade) {
                    $responseBody[] = array(
                        'id' => $cidade->getId(),
                        'cidade' => $cidade->getCidade(),
                        'estado' => $estado
                    );
                }
            }
            else {
                $response->setStatusCode(404);
                $responseBody = array(
                    'erro' => 'Nenhuma cidade encontrada.'
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