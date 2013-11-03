<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CaixasMovimentosTipos
 */
class CaixasMovimentosTipos
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
     * @var \DateTime
     */
    private $excluido;

    /**
     * @var string
     */
    private $movimentoTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $tipo;


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
     * @return CaixasMovimentosTipos
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
     * Set excluido
     *
     * @param \DateTime $excluido
     * @return CaixasMovimentosTipos
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
     * Set movimentoTipo
     *
     * @param string $movimentoTipo
     * @return CaixasMovimentosTipos
     */
    public function setMovimentoTipo($movimentoTipo)
    {
        $this->movimentoTipo = $movimentoTipo;
    
        return $this;
    }

    /**
     * Get movimentoTipo
     *
     * @return string 
     */
    public function getMovimentoTipo()
    {
        return $this->movimentoTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CaixasMovimentosTipos
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
     * Set tipo
     *
     * @param boolean $tipo
     * @return CaixasMovimentosTipos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return boolean 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}