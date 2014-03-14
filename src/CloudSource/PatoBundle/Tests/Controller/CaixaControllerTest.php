<?php

namespace CloudSource\PatoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CaixaControllerTest extends WebTestCase {

    private $cliet;

    public function setUp() {
        $this->client = static::createClient();
    }

    /**
     * Verifica se abre corretamente a pagina iniial de configuração
     */
    public function testCaixaConfigHome() {

        $crawler = $this->client->request('GET', '/configuracao/caixa');

        print_r('ma oe');
        print_r($crawler);

        //$this->assertTrue($crawler->filter('html:contains("Adicionar novo caixa")')->count() > 0);
    }



}