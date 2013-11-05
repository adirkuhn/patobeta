<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresas
 */
class Empresas
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
     * @var \DateTime
     */
    private $atualizado;

    /**
     * @var string
     */
    private $razaoSocial;

    /**
     * @var string
     */
    private $nomeFantasia;

    /**
     * @var string
     */
    private $cnpj;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $site;

    /**
     * @var string
     */
    private $endereco;

    /**
     * @var string
     */
    private $enderecoComplemento;

    /**
     * @var string
     */
    private $bairro;

    /**
     * @var \CloudSource\PatoBundle\Entity\Cidades
     */
    private $cidade;

    /**
     * @var \CloudSource\PatoBundle\Entity\Usuarios
     */
    private $criador;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $empregados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->empregados = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set criado
     *
     * @param \DateTime $criado
     * @return Empresas
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
     * @return Empresas
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
     * Set atualizado
     *
     * @param \DateTime $atualizado
     * @return Empresas
     */
    public function setAtualizado($atualizado)
    {
        $this->atualizado = $atualizado;
    
        return $this;
    }

    /**
     * Get atualizado
     *
     * @return \DateTime 
     */
    public function getAtualizado()
    {
        return $this->atualizado;
    }

    /**
     * Set razaoSocial
     *
     * @param string $razaoSocial
     * @return Empresas
     */
    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;
    
        return $this;
    }

    /**
     * Get razaoSocial
     *
     * @return string 
     */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * Set nomeFantasia
     *
     * @param string $nomeFantasia
     * @return Empresas
     */
    public function setNomeFantasia($nomeFantasia)
    {
        $this->nomeFantasia = $nomeFantasia;
    
        return $this;
    }

    /**
     * Get nomeFantasia
     *
     * @return string 
     */
    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    /**
     * Set cnpj
     *
     * @param string $cnpj
     * @return Empresas
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    
        return $this;
    }

    /**
     * Get cnpj
     *
     * @return string 
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Empresas
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Empresas
     */
    public function setSite($site)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set endereco
     *
     * @param string $endereco
     * @return Empresas
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    
        return $this;
    }

    /**
     * Get endereco
     *
     * @return string 
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set enderecoComplemento
     *
     * @param string $enderecoComplemento
     * @return Empresas
     */
    public function setEnderecoComplemento($enderecoComplemento)
    {
        $this->enderecoComplemento = $enderecoComplemento;
    
        return $this;
    }

    /**
     * Get enderecoComplemento
     *
     * @return string 
     */
    public function getEnderecoComplemento()
    {
        return $this->enderecoComplemento;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     * @return Empresas
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    
        return $this;
    }

    /**
     * Get bairro
     *
     * @return string 
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set cidade
     *
     * @param \CloudSource\PatoBundle\Entity\Cidades $cidade
     * @return Empresas
     */
    public function setCidade(\CloudSource\PatoBundle\Entity\Cidades $cidade = null)
    {
        $this->cidade = $cidade;
    
        return $this;
    }

    /**
     * Get cidade
     *
     * @return \CloudSource\PatoBundle\Entity\Cidades 
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set criador
     *
     * @param \CloudSource\PatoBundle\Entity\Usuarios $criador
     * @return Empresas
     */
    public function setCriador(\CloudSource\PatoBundle\Entity\Usuarios $criador = null)
    {
        $this->criador = $criador;
    
        return $this;
    }

    /**
     * Get criador
     *
     * @return \CloudSource\PatoBundle\Entity\Usuarios 
     */
    public function getCriador()
    {
        return $this->criador;
    }

    /**
     * Add empregados
     *
     * @param \CloudSource\PatoBundle\Entity\Clientes $empregado
     * @return Caixas
     */
    public function addEmpregados(\CloudSource\PatoBundle\Entity\Clientes $empregado)
    {
        $this->empregados[] = $empregado;
    
        return $this;
    }

    /**
     * Remove empregado
     *
     * @param \CloudSource\PatoBundle\Entity\Clientes $empregado
     */
    public function removeEmpregados(\CloudSource\PatoBundle\Entity\Clientes $empregado)
    {
        $this->empregado->removeElement($empregado);
    }

    /**
     * Get empregado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmpregados()
    {
        return $this->empregados;
    }
}