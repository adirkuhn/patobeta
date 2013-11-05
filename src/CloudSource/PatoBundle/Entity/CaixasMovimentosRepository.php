<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CaixasMovimentosRepository extends EntityRepository
{
    /**
     * Busca todos os movimentos de um mês
     * 
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $caixa Caixa que deverá ser retornado os movimentos
     * @param string $mes Mês de qual deverá ser retornado os movimentos
     * 
     **/
    public function pegarMovimentosMes($caixa, $mes)
    {
        $dtInicio = date('Y-' . $mes . '-01');
        $dtFim = date('Y-' . $mes . '-31');

        return $this->getEntityManager()
            ->createQuery('
                SELECT
                    c
                FROM
                    PatoBundle:CaixasMovimentos c
                WHERE
                    c.caixa = :caixa
                AND
                    c.dtMovimento
                BETWEEN
                    :dtInicio
                AND
                    :dtFim
                    
            ')
            //->setParameter('dtInicio', $dtInicio)
            ->setParameters(array(
                'caixa' => $caixa,
                'dtInicio' => $dtInicio,
                'dtFim' => $dtFim
            ))
            ->getResult();
    }

    /**
     * Retorna balanço de movimentos de um mês
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $caixa Caixa que deverá ser retornado os movimentos
     * @param string $mes Mês de qual deverá ser retornado os movimentos
     * 
     **/
    public function pegarBalancoMensal($caixa, $mes)
    {
        $entradas = (float) $this->pegarSomaMovimentos($caixa, 0, $mes, 1)[0]['total'];
        $saidas = (float) $this->pegarSomaMovimentos($caixa, 0, $mes, 0)[0]['total'];

        return array(
            'entradas' => $entradas,
            'saidas' => $saidas,
            'balanco' => (float)($entradas - $saidas)
        );
    }

    /**
     * Retorna balanço de movimentos do ano atual
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $caixa Caixa que deverá ser retornado os movimentos
     * @param string $mes Mês de qual deverá ser retornado os movimentos
     * 
     **/
    public function pegarBalancoAnual($caixa, $ano)
    {
        $entradas = (float) $this->pegarSomaMovimentos($caixa, $ano, 0, 1)[0]['total'];
        $saidas = (float) $this->pegarSomaMovimentos($caixa, $ano, 0, 0)[0]['total'];

        return array(
            'entradas' => $entradas,
            'saidas' => $saidas,
            'balanco' => (float)($entradas - $saidas)
        );
    }

    /**
     * Retorna valores de um tipo de movimento de caixa mensal
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @param int $caixa Caixa que deverá ser retornado os movimentos
     * @param string $ano Ano de qual devera ser retornado o caixa (0 para ano atual)
     * @param string $mes Mês de qual deverá ser retornado os movimentos ou 0 para todos os meses
     * @param int $tipo Tipo de movimento entrada(1) ou saida(0)
     * 
     * 
     **/
    protected function pegarSomaMovimentos($caixa, $ano=0, $mes=0, $tipo)
    {
        if ($ano == 0) {
            $ano = date('Y');
        }

        if ($mes === 0) {
            $dtInicio = date($ano . '-01-01');
            $dtFim = date($ano . '-12-31');
        }
        else {
            $dtInicio = date($ano . '-' . $mes . '-01');
            $dtFim = date($ano . '-' . $mes . '-31');
        }

        return $this->getEntityManager()
            ->createQuery('
                SELECT
                    sum(c.valor) as total
                FROM
                    PatoBundle:CaixasMovimentos c
                JOIN
                    PatoBundle:CaixasMovimentosTipos d
                WHERE
                    c.caixaMovimentoTipo = d.id
                AND
                    d.tipo = :tipo
                AND
                    c.caixa = :caixa
                AND
                    c.dtMovimento
                BETWEEN
                    :dtInicio
                AND
                    :dtFim
            ')
            ->setParameters(array(
                'caixa' => $caixa,
                'dtInicio' => $dtInicio,
                'dtFim' => $dtFim,
                'tipo' => $tipo,
            ))
            ->getResult();
    }

}