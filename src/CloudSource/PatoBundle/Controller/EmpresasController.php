<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormEvents;

use CloudSource\PatoBundle\Entity\Empresas;
use CloudSource\PatoBundle\Entity\Usuarios;
use CloudSource\PatoBundle\Form\Type\EmpresasType;

/**
* Classe que gerencia o crud de empresas
*/
class EmpresasController extends Controller
{

    /**
     * Exibe página inicial de empresas
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return Response Página inicial de empresas
     **/
    public function indexAction()
    {
        $em = $this->getDoctrine()->getRepository('PatoBundle:Empresas');
        $empresas = $em->findAll();
        //$empresas = $this->page(1);
        return $this->render('PatoBundle:Empresas:index.html.twig', array('empresas' => $empresas));
    }

    /**
     * Página de cadastro de empresa
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return Response Página de cadastro de empresas
     **/
    public function novaAction()
    {
        $emp = new Empresas();

        $form = $this->createForm(new EmpresasType());

        return $this->render('PatoBundle:Empresas:nova.html.twig', array('form' => $form->createView()));
    }

    /**
     * Salva um cliente
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return Response Página com resultado de cadastro de nova empresa
     **/
    public function novaSalvaAction(Request $request)
    {

        $form = $this->createForm(new EmpresasType(), new Empresas());

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getEntityManager();

            try {
                $empresa = $form->getData();
                $empresa->setCriado(new \Datetime('now'));
                //TODO:pegar usuario logado
                $empresa->setCriador($em->find('PatoBundle:Usuarios', 1));
                
                $em->persist($empresa);
                $em->flush();

                return $this->render('PatoBundle:Empresas:nova.html.twig', array('form' => $form->createView()));
            }
            catch(Exception $e) {
                //TODO: melhorar tratamento de erro
                die('Erro ao salvar empresa');
            }

        }
    }

    /**
     * Ver dados de um empresa
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $id Identificação da empresa
     *
     * @return Response Página com dados de uma empresa
     **/
    public function verAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $empresa = $em->find('PatoBundle:Empresas', $id);

        if ($empresa instanceof Empresas) {
            return $this->render('PatoBundle:Empresas:ver.html.twig', array('empresa' => $empresa));
        }

        //not found
        return new Response('Page not found.', 404);
    }

    /**
     * Editar dados de uma empresa
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     *
     * @param int $id Identificação da empresa
     *
     * @return Respose Página para editar dados de um empresa
     **/
    public function editarAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $empresa = $em->find('PatoBundle:Empresas', $id);

        if ($empresa instanceof Empresas) {

            $form = $this->createForm(new EmpresasType(), $empresa);

            //$form->handleRequest($request);

            return $this->render('PatoBundle:Empresas:editar.html.twig', array(
                'form' => $form->createView(),
                'empresa' => $empresa
            ));

        }
        else {
            //TODO: tratar erro caso nao encontre empresa, provisoriamente jogando pra home empresas

            return $this->redirect($this->generateUrl('pato_empresa_homepage'));
        }
    }

    /**
     * Atualiza dados de uma empresa
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param Request $request Dados da empresa a ser atualizados
     * 
     * @return Response Página de edição com mensagem de atualização
     **/
    public function editarAtualizarAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $empresa = $em->find('PatoBundle:Empresas', $id);

        if ($empresa instanceof Empresas) {
        
            $form = $this->createForm(new EmpresasType(), $empresa);
            $form->handleRequest($request);

            if ($form->isValid()) {
                try {
                    $empresa = $form->getData();
                    $empresa->setAtualizado(new \Datetime('now'));
                    //TODO:pegar usuario logado
                    //$empresa->setCriador($em->find('PatoBundle:Usuarios', 1));
                    
                    $em->persist($empresa);
                    $em->flush();

                    return $this->render('PatoBundle:Empresas:ver.html.twig', array(
                        'empresa' => $empresa
                    ));
                }
                catch(Exception $e) {
                    //TODO: melhorar tratamento de erro
                    //die('Erro ao atualizar empresa');
                    return $this->render('PatoBundle:Empresas:editar.html.twig', array(
                        'form' => $form->createView(),
                        'empresa' => $empresa,
                        'erro' => $e
                    ));
                }
            }
        }
        else {
            return new Response('Erro ao atualizar empresa. Recurso nao encontrado', 404);
        }
    }


    /**
     * Retorna as informações de uma empresa
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $id Identificação da empresa a ser retornado
     * 
     * @return mixed[] array Dados da empresa
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
        $em = $this->getDoctrine()->getEntityManager();

        //busca empresa
        $cliente = null;
        if ($id > 0) {
            $cliente = $em->find('PatoBundle:Empresas', $id);

            if($cliente instanceof Empresas) {
                $responseBody = array(
                    'id' => $cliente->getId(),
                    'nome' => $cliente->getNomeFantasia()
                );
            } else {
                $response->setStatusCode(404);
                $responseBody = array(
                    'erro' => 'Empresa não existe.'
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

    /** TODO: Refazer tuto essa funssao
     * Retona uma lista de empreas com alguns detalhes, por página
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param int $page Página a ser recuparada
     *
     * @return mixed[] array Lista de empreas por página
     **/
    protected function page($page)
    {
        //sanitiza
        $page = (int) $page;

        //pega repositorio de dados
        $em = $this->getDoctrine()->getEntityManager();

        $query = $em->createQuery('
            SELECT
                e.nomeFantasia,
                e.email
            FROM
                PatoBundle:Empresas e
        ');

        $results = $query->getResult();

        

        $responseBody = array();
        foreach ($results as $result) {
            $responseBody[] = array(
                'nomeFantasia' => $result['nomeFantasia'],
                'email' => $result['email']
            );
        }
        

        //TODO: retirando chamadas rest para teste de implementação
        //resposta
        //$response = new Response();
        //$response->headers->set('Content-Type', 'application/json');
        //$response->setContent(json_encode($responseBody));

        return $responseBody;
    }

    /**
     * Salva uma nova empresa
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     *
     * @return mixed[] Array Dados da empresa
     **/
    public function postAction()
    {
        //resposta
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $responseBody = null;

        //pega dados do post e sanitiza
        $post = array_map('addslashes', $this->getRequest()->request->all());

        //verifica se esta sendo passado as chaves necessarias
        if (array_key_exists('nomeFantasia', $post)) {

            //pega repositorio de dados
            $em = $this->getDoctrine()->getEntityManager();

            $empresa = new Empresas();

            $empresa->setNomeFantasia($post['nomeFantasia']);
            $empresa->setCriado(new \Datetime('now'));

            //TODO:pegar usuario logado
            $user = $em->find('PatoBundle:Usuarios', 1);
            if ($user instanceof Usuarios) {
                $empresa->setCriador($user);

                try {
                //salva
                $em->persist($empresa);
                $em->flush();

                //define resposta
                $post['id'] = $empresa->getId();
                $response->setStatusCode(201);
                $responseBody = $post;

                } catch (\Doctrine\DBAL\DBALException $e) {
                    //define resposta
                    $response->setStatusCode(409);
                    $responseBody = array(
                        'erro' => 'Empresa já existe.'
                    );
                }
            } else {
                die('macarena');
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

    /**
     * Busca uma empresa pelo nome
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * @param string $nome Nome ou parte do nome da empresa a ser buscada
     * 
     * @return mixed[] array Nome e Id da empresa buscada
     **/
    public function buscaAction($nome)
    {
        //resposta
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $responseBody = null;

        //sanitiza o nome
        $nome = addslashes($nome);

        //pega repositorio de dados
        $em = $this->getDoctrine()->getEntityManager();

        //busca empresa
        $cliente = null;
        if (!empty($nome) && strlen($nome) > 2) {
            $consulta = $em->createQuery('
                SELECT
                    e.id,
                    e.nomeFantasia,
                    e.razaoSocial
                FROM
                    PatoBundle:Empresas e
                WHERE
                    e.nomeFantasia LIKE :nome
                OR
                    e.razaoSocial LIKE :nome
            ')
            ->setParameter('nome', '%'.$nome.'%');
            
            $responseBody = $consulta->getResult();
        } else {
            $response->setStatusCode(400);
            $responseBody = array(
                'erro' => 'Requisição inválida.'
            );
        }

        $response->setContent(json_encode($responseBody));

        return $response;
    }
}