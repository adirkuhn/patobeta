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
     * @param $mes Mês de qual deverá ser retornado os movimentos
     *
     * 
     **/
    public function pegarMovimentosMes($caixa, $mes)
    {
        $dtInicio = date('Y-' . $mes . '-01');
        $dtFim = date('Y-' . $mes . '-31');

        return $this->getEntityManager()
            ->createQuery(
                'SELECT
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
                    '
            )
            //->setParameter('dtInicio', $dtInicio)
            ->setParameters(array(
                'caixa' => $caixa,
                'dtInicio' => $dtInicio,
                'dtFim' => $dtFim
            ))
            ->getResult();
    }
}