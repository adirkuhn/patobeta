<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use CloudSource\PatoBundle\Entity\Usuarios;

/**
* Classe que gerencia o crud de usuarios
*/
class UsuariosController extends Controller
{
    /**
     * Retorna as informações de um usuario
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $id Identificação do usuario
     * 
     * @return mixed[] array Dados do usuario
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

        //busca usuario
        if ($id > 0) {
            $usuario = $em->find('PatoBundle:Usuarios', $id);

            if ($usuario instanceof Usuarios) {
                $response->setStatusCode(200);
                $responseBody = array(
                    'id' => $usuario->getId(),
                    'nome' => $usuario->getNome(),
                    'email' => $usuario->getEmail()
                );
            }
            else {
                $response->setStatusCode(404);
                $responseBody = array(
                    'erro' => 'Usuário não existe.'
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
     * Salva um usuário
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param mixed[] json $dados Dados do usuário a ser cadastrado
     *
     * @return mixed[] json Informações do usuário
     **/
    function postAction()
    {
        //resposta
        $responseBody = null;
        $response = new Response();
        
        //pega dados do post e sanitiza
        $post = array_map('addslashes', $this->getRequest()->request->all());

        //verifica se esta sendo passado a chave necessaria
        if(array_key_exists('nome', $post) && array_key_exists('email', $post) 
            && array_key_exists('senha', $post)
        ) 
        {

            //pega entity manager (gerenciador de entidades)
            $em = $this->getDoctrine()->getEntityManager();

            //novo usuario
            $usuario = new Usuarios();
            $usuario->setNome($post['nome']);
            $usuario->setEmail($post['email']);

            //criptografa a senha
            $encoderFactory = $this->get('security.encoder_factory');
            $encoder = $encoderFactory->getEncoder($usuario);

            $usuario->setSenha($encoder->encodePassword($post['senha'], $usuario->getSalt()));

            try {
                //salva
                $em->persist($usuario);
                $em->flush();

                //define resposta
                $post['id'] = $usuario->getId();
                $response->setStatusCode(201);
                $responseBody = $post;

            } catch (\Doctrine\DBAL\DBALException $e) {
                //define resposta
                $response->setStatusCode(409);
                $responseBody = array(
                    'erro' => 'Usuário já existe.'
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