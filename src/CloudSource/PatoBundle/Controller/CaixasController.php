<?php

namespace CloudSource\PatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use CloudSource\PatoBundle\Entity\Caixas;
use CloudSource\PatoBundle\Entity\CaixasMovimentos;
use CloudSource\PatoBundle\Entity\CaixasMovimentosTipos;
use CloudSource\PatoBundle\Form\Type\CaixasType;

/**
 *
 * Classe gerenciar caixa
 **/
class CaixasController extends Controller
{
    /**
     * Retorna página inicial do caixa
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $caixa Identificação do caixa
     * @param string $mes Mês a ser exibido
     * @param string $ano Ano a ser exibido
     * 
     * @return Response Página inicial do caixa
     **/
    public function indexAction($caixa, $mes, $ano)
    {

        $em = $this->getDoctrine()->getRepository('PatoBundle:Caixas');
        $caixas = $em->findAll();

        //se nao houver caixas redireciar para tutorial para criacao de novo
        if (empty($caixas)) {
            return $this->redirect($this->generateUrl('pato_configuracao_caixa_index'));
        }

        $caixa = ($caixa == 0)? $caixas[$caixa]->getId(): $caixa;

        $caixaSelecionado = $em->find($caixa);

        //se mes = 0 mes = mes atual
        $mes = ($mes == 0)? date('m') : $mes;

        //se ano = 0 ano = ano atual
        $ano = ($ano == 0)? date('Y') : $ano;

        $em = $this->getDoctrine()->getRepository('PatoBundle:CaixasMovimentos');

        //lista de anos que houveram movimento + ano corrente
        $tempAnos = $em->pegarAnosMovimento();
        $anos = array();
        foreach ($tempAnos as $tempAno) {
            $anos[] = $tempAno['ano'];
        }
        $anos[] = date('Y');
        $anos = array_unique($anos);

        $movimentos = $em->pegarMovimentosMes($caixa, $mes, $ano);
        
        $balancoMensal = $em->pegarBalancoMensal($caixa, $mes, $ano);

        $balancoAnual = $em->pegarBalancoAnual($caixa, $ano);



        return $this->render('PatoBundle:Caixas:index.html.twig', array(
            'caixas' => $caixas,
            'caixaSelecionado' => $caixaSelecionado,
            'movimentos' => $movimentos,
            'balancoMensal' => $balancoMensal,
            'balancoAnual' => $balancoAnual,
            'mes' => $mes,
            'ano' => $ano,
            'anos' => $anos,
        ));

    }

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
     * Pagina inicial de configuração do caixa
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     *
     * @return Response
     **/
    public function configuracaoCaixaIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $caixas = $em->getRepository('PatoBundle:Caixas')->findAll();

        return $this->render('PatoBundle:Configuracao:Caixa/index.html.twig', array(
            'caixas' => $caixas
        ));
    }

    /**
     * Adiciona novo caixa
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return Response Página de cadastro de novo caixa
     **/
    public function configuracaoCaixaCrudNovoAction(Request $request)
    {

        $form = $this->createForm(new CaixasType(), new Caixas());

        $form->handleRequest($request);

        //salva caixa
        $salvo = false;
        $msg_erro = '';
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $caixa = $form->getData();
                $caixa->setCriado(new \Datetime('now'));
                //TODO:pegar usuario logado
                //$caixa->setCriador($em->find('PatoBundle:Usuarios', 1));
                
                $em->persist($caixa);
                $em->flush();

                $salvo = true;
            }
            catch(\Doctrine\DBAL\DBALException $e) {
                $msg_erro = 'Não é possivel criar caixas com nomes duplicados.';
            }
            catch(Exception $e) {
                //TODO: melhorar tratamento de erro
                //die('Erro ao salvar caixa');
            }
        }

        return $this->render('PatoBundle:Configuracao:Caixa/novo.html.twig', array(
            'form' => $form->createView(),
            'salvo' => $salvo,
            'msg_erro' => $msg_erro
        ));
    }

    /**
     * Edita um caixa
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $id Identificação do caixa.
     * 
     * @return 
     **/
    public function configuracaoCaixaCrudEditarAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $caixa = $em->find('PatoBundle:Caixas', $id);

        if ($caixa instanceof Caixas) {

            $form = $this->createForm(new CaixasType(), $caixa);

            return $this->render('PatoBundle:Configuracao:Caixa/editar.html.twig', array(
                'form' => $form->createView(),
                'caixa' => $caixa
            ));

        }
        else {
            //TODO: tratar erro caso nao encontre caixa, provisoriamente jogando pra home conf caixa

            return $this->redirect($this->generateUrl('pato_configuracao_caixa_index'));
        }
    }

    /**
     * Atualiza dados de um caixa
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param Request $request Dados do caixa a ser atualizados
     * 
     * @return Response Página de edição com mensagem de atualização
     **/
    public function configuracaoCaixaCrudEditarAtualizarAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $caixa = $em->find('PatoBundle:Caixas', $id);

        if ($caixa instanceof Caixas) {
        
            $form = $this->createForm(new CaixasType(), $caixa);
            $form->handleRequest($request);

            if ($form->isValid()) {
                try {
                    $caixa = $form->getData();
                    //$caixa->setAtualizado(new \Datetime('now'));
                    //TODO:pegar usuario logado
                    //$caixa->setCriador($em->find('PatoBundle:Usuarios', 1));
                    
                    $em->persist($caixa);
                    $em->flush();

                    return $this->render('PatoBundle:Configuracao:Caixa/editar.html.twig', array(
                        'form' => $form->createView(),
                        'caixa' => $caixa,
                        'salvo' => true
                    ));
                }
                catch(Exception $e) {
                    //TODO: melhorar tratamento de erro
                    return $this->render('PatoBundle:Configuracao:Caixa/editar.html.twig', array(
                        'form' => $form->createView(),
                        'caixa' => $caixa,
                        'erro' => $e
                    ));
                }
            }
        }
        else {
            return new Response('Erro ao atualizar caixa. Recurso nao encontrado', 404);
        }
    }

    /**
     * Deleta um caixa que não possui movimentos
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param Int $id Identificação do caixa que será apagado
     *
     * @return 
     **/
    public function configuracaoCaixaCrudDeletarAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $caixa = $em->find('PatoBundle:Caixas', $id);

        //verifica se encontrou o caixa com a id informada
        if ($caixa instanceof Caixas) {
            //verifica se não há movimentos
            if (count($caixa->getCaixaMovimentos()) === 0 ) {
                $em->remove($caixa);
                $em->flush();
            }
            else {
                $caixas = $em->getRepository('PatoBundle:Caixas')->findAll();
                return $this->render('PatoBundle:Configuracao:Caixa/index.html.twig', array(
                    'msg_erro' => 'Não é possivel deletar caixas com movimentação.',
                    'caixas'=> $caixas
                ));
            }

        }

        return $this->redirect($this->generateUrl('pato_configuracao_caixa_index'));
    }
}