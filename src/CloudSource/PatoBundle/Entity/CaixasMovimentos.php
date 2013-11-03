<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CaixasMovimentos
 */
class CaixasMovimentos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $criado;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $excluido;

    /**
     * @var \DateTime
     */
    private $dtMovimento;

    /**
     * @var float
     */
    private $valor;

    /**
     * @var \CloudSource\PatoBundle\Entity\Caixas
     */
    private $caixa;

    /**
     * @var \CloudSource\PatoBundle\Entity\CaixasMovimentosTipos
     */
    private $caixaMovimentoTipo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set criado
     *
     * @param \DateTime $criado
     * @return CaixasMovimentos
     */
    public function setCriado($criado)
    {
        $this->criado = $criado;
    
        return $this;
    }

    /**
     * Get criado
     *
     * @return \DateTime 
     */
    public function getCriado()
    {
        return $this->criado;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CaixasMovimentos
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set excluido
     *
     * @param \DateTime $excluido
     * @return CaixasMovimentos
     */
    public function setExcluido($excluido)
    {
        $this->excluido = $excluido;
    
        return $this;
    }

    /**
     * Get excluido
     *
     * @return \DateTime 
     */
    public function getExcluido()
    {
        return $this->excluido;
    }

    /**
     * Set dtMovimento
     *
     * @param \DateTime $dtMovimento
     * @return CaixasMovimentos
     */
    public function setDtMovimento($dtMovimento)
    {
        $this->dtMovimento = $dtMovimento;
    
        return $this;
    }

    /**
     * Get dtMovimento
     *
     * @return \DateTime 
     */
    public function getDtMovimento()
    {
        return $this->dtMovimento;
    }

    /**
     * Set valor
     *
     * @param float $valor
     * @return CaixasMovimentos
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return float 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set caixa
     *
     * @param \CloudSource\PatoBundle\Entity\Caixas $caixa
     * @return CaixasMovimentos
     */
    public function setCaixa(\CloudSource\PatoBundle\Entity\Caixas $caixa = null)
    {
        $this->caixa = $caixa;
    
        return $this;
    }

    /**
     * Get caixa
     *
     * @return \CloudSource\PatoBundle\Entity\Caixas 
     */
    public function getCaixa()
    {
        return $this->caixa;
    }

    /**
     * Set caixaMovimentoTipo
     *
     * @param \CloudSource\PatoBundle\Entity\CaixasMovimentosTipos $caixaMovimentoTipo
     * @return CaixasMovimentos
     */
    public function setCaixaMovimentoTipo(\CloudSource\PatoBundle\Entity\CaixasMovimentosTipos $caixaMovimentoTipo = null)
    {
        $this->caixaMovimentoTipo = $caixaMovimentoTipo;
    
        return $this;
    }

    /**
     * Get caixaMovimentoTipo
     *
     * @return \CloudSource\PatoBundle\Entity\CaixasMovimentosTipos 
     */
    public function getCaixaMovimentoTipo()
    {
        return $this->caixaMovimentoTipo;
    }
}
