<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caixas
 */
class Caixas
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $criado;

    /**
     * @var \DateTime
     */
    private $excluido;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $caixaMovimentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->caixaMovimentos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set nome
     *
     * @param string $nome
     * @return Caixas
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    
        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Caixas
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
     * Set criado
     *
     * @param \DateTime $criado
     * @return Caixas
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
     * @return Caixas
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
     * Add caixaMovimentos
     *
     * @param \CloudSource\PatoBundle\Entity\CaixasMovimentos $caixaMovimentos
     * @return Caixas
     */
    public function addCaixaMovimento(\CloudSource\PatoBundle\Entity\CaixasMovimentos $caixaMovimentos)
    {
        $this->caixaMovimentos[] = $caixaMovimentos;
    
        return $this;
    }

    /**
     * Remove caixaMovimentos
     *
     * @param \CloudSource\PatoBundle\Entity\CaixasMovimentos $caixaMovimentos
     */
    public function removeCaixaMovimento(\CloudSource\PatoBundle\Entity\CaixasMovimentos $caixaMovimentos)
    {
        $this->caixaMovimentos->removeElement($caixaMovimentos);
    }

    /**
     * Get caixaMovimentos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCaixaMovimentos()
    {
        return $this->caixaMovimentos;
    }
}
