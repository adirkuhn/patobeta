<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use CloudSource\PatoBundle\Entity\Clientes;
use CloudSource\PatoBundle\Entity\Usuarios;
use CloudSource\PatoBundle\Entity\Empresas;
use CloudSource\PatoBundle\Entity\Cidades;

/**
* Classe que gerencia o crud de clientes
*/
class ClientesController extends Controller
{

    /**
     * Página inicial dos clientes
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return Response Página inicial de clientes
     **/
    public function indexAction()
    {
        return $this->render('PatoBundle:Clientes:index.html.twig');
    }

    /**
     * Página de cadastro de novos clientes
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return Response Página de cadastro de clientes
     */
    public function novoAction() 
    {
        return $this->render('PatoBundle:Clientes:novo.html.twig');
    }

    /**
     * Página para ver dados de um cliente
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $id Id do cliente
     * 
     * @return Response Página com os dados do cliente
     */
    public function verAction($id)
    {
        //sanitiza o id
        $id = (int) $id;

        //pega repositorio de dados
        $em = $this->getDoctrine()->getManager();

        $cliente = $em->find('PatoBundle:Clientes', $id);

        if ($cliente instanceof Clientes) {
            return $this->render('PatoBundle:Clientes:ver.html.twig', array('cliente' => $cliente));
        } else {
            //TODO: redirecionar para página de 404
            die('404');
        }
    }

    /**
     * Página de editar dados de um cliente
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $id Id do cliente
     * 
     * @return Response Página de edição
     */
    public function editarAction($id) 
    {
        //sanitiza o id
        $id = (int) $id;

        //pega repositorio de dados
        $em = $this->getDoctrine()->getManager();

        $cliente = $em->find('PatoBundle:Clientes', $id);

        if ($cliente instanceof Clientes) {
            return $this->render('PatoBundle:Clientes:editar.html.twig', array('cliente' => $cliente));
        } else {
            //TODO: redirecionar para página de 404
            die('404');
        }
    }

    /**
     * Retorna as informações de um cliente
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $id Identificação do cliente a ser retornado
     * 
     * @return mixed[] array Dados do cliente
     **/
    public function getAction($id)
    {
        //resposta
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $responseBody = null;

        //sanitiza o id
        $id = (int) $id;

        //pega repositorio de dados
        $em = $this->getDoctrine()->getManager();

        //busca cliente
        $cliente = null;
        if ($id > 0) {
            $cliente = $em->find('PatoBundle:Clientes', $id);

            if($cliente instanceof Clientes) {
                $responseBody = array(
                    'id' => $cliente->getId(),
                    'nome' => $cliente->getNome()
                );
            } else {
                $response->setStatusCode(404);
                $responseBody = array(
                    'erro' => 'Cliente não existe.'
                );
            }
        } else {
            $response->setStatusCode(400);
            $responseBody = array(
                'erro' => 'Requisição inválida.'
            );
        }

        $response->setContent(json_encode($responseBody));

        return $response;
    }

    /**
     * Retona uma lista de clientes com alguns detalhes, por página
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $page Página a ser recuparada
     *
     * @return mixed[] array Lista de clientes por página
     **/
    function pageAction($page)
    {
        //sanitiza
        $page = (int) $page;

        //pega repositorio de dados
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('
            SELECT
                c.nome,
                c.telefone,
                e.nomeFantasia
            FROM
                PatoBundle:Clientes c
            LEFT JOIN
                c.empresa e
        ');

        $results = $query->getArrayResult();

        $responseBody = array();
        foreach ($results as $result) {
            $responseBody['aaData'][] = array_values($result);
        }

        //resposta
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($responseBody));

        return $response;
    }

    /**
     * Salva um novo cliente
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     *
     * @return mixed[] Array Dados do cliente
     **/
    public function postAction()
    {
        //resposta
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $responseBody = null;

        //pega dados do post e sanitiza
        $post = array_map('addslashes', $this->getRequest()->request->all());

        // print_r($post);die('jojojo');

        //verifica se esta sendo passado as chaves necessarias
        //TODO: tratar erro de 'nome em branco' campo obrigatorio
        if (array_key_exists('nome', $post) && !empty($post['nome'])) {

            //pega repositorio de dados
            $em = $this->getDoctrine()->getManager();

            //Verifica se esta sendo passado ID, nesse caso é update
            if (isset($post['id']) && $post['id'] > 0) {
                $cliente = $em->find('PatoBundle:Clientes', $post['id']);
                //define nova data de atualizacao;
                $cliente->setAtualizado(new \Datetime('now'));
                //TODO: tratar da forma certa o erro
                if (!$cliente instanceof Clientes) {
                    die('404 erro cliente nao encontrado');
                }
            } else {
                //caso não esteja sendo passo ID não é update então cria-se um novo cliente
                $cliente = new Clientes();
                $cliente->setCriado(new \Datetime('now'));
            }

            //dados do cliente
            $cliente->setNome($post['nome']);
            $cliente->setEmail($post['email']);
            $cliente->setRg($post['rg']);
            $cliente->setCpf($post['cpf']);
            $cliente->setTelefone($post['telefone']);
            $cliente->setCelular($post['celular']);
            $cliente->setEndereco($post['endereco']);
            $cliente->setEnderecoComplemento($post['complemento']);
            $cliente->setBairro($post['bairro']);
            $cliente->setDescricao($post['descricao']);


            //verifica se empresa é valida e seta no cliente
            if (!empty($post['empresa'])) {
                $empresa = $em->find('PatoBundle:Empresas', $post['empresa']);
                if ($empresa instanceof Empresas)
                {
                    $cliente->setEmpresa($empresa);
                }
            }

            //verifica se a cidade e valida e seta no cliente
            if (!empty($post['cidade'])) {
                $cidade = $em->find('PatoBundle:Cidades', $post['cidade']);
                if ($cidade instanceof Cidades) {
                    $cliente->setCidade($cidade);
                }
            }


            //TODO:pegar usuario logado
            $user = $em->find('PatoBundle:Usuarios', 1);
            if ($user instanceof Usuarios) {
                $cliente->setCriador($user);

                try {
                //salva
                $em->persist($cliente);
                $em->flush();

                //define resposta
                $post['id'] = $cliente->getId();
                $response->setStatusCode(200);
                $responseBody = $post;

                } catch (\Doctrine\DBAL\DBALException $e) {

                    //define resposta
                    $response->setStatusCode(409);
                    $responseBody = array(
                        'erro' => 'Cliente já existe.'
                    );
                }
            } else {
                //TODO: tratar erro de forma humanitaria
                die('Usuario Não existe');
            }

        } else {
            //erro nao foi passado chaves suficientes
            $responseBody = array(
                'erro' => 'Requisição inválida.'
            );
            $response->setStatusCode(400);
        }

        //define corpo da resposta
        $response->setContent(json_encode($responseBody));

        return $response;
    }

}