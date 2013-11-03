<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clientes
 */
class Clientes
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
    private $email;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $rg;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var string
     */
    private $celular;

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
     * @var \DateTime
     */
    private $atualizado;

    /**
     * @var \CloudSource\PatoBundle\Entity\Cidades
     */
    private $cidade;

    /**
     * @var \CloudSource\PatoBundle\Entity\ClientesTipos
     */
    private $clientesTipos;

    /**
     * @var \CloudSource\PatoBundle\Entity\Usuarios
     */
    private $criador;

    /**
     * @var \CloudSource\PatoBundle\Entity\Empresas
     */
    private $empresa;


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
     * @return Clientes
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
     * Set email
     *
     * @param string $email
     * @return Clientes
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
     * Set cpf
     *
     * @param string $cpf
     * @return Clientes
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    
        return $this;
    }

    /**
     * Get cpf
     *
     * @return string 
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set rg
     *
     * @param string $rg
     * @return Clientes
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
    
        return $this;
    }

    /**
     * Get rg
     *
     * @return string 
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     * @return Clientes
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    
        return $this;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Clientes
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    
        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set endereco
     *
     * @param string $endereco
     * @return Clientes
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
     * @return Clientes
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
     * @return Clientes
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
     * Set descricao
     *
     * @param string $descricao
     * @return Clientes
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
     * @return Clientes
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
     * @return Clientes
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
     * @return Clientes
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
     * Set cidade
     *
     * @param \CloudSource\PatoBundle\Entity\Cidades $cidade
     * @return Clientes
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
     * Set clientesTipos
     *
     * @param \CloudSource\PatoBundle\Entity\ClientesTipos $clientesTipos
     * @return Clientes
     */
    public function setClientesTipos(\CloudSource\PatoBundle\Entity\ClientesTipos $clientesTipos = null)
    {
        $this->clientesTipos = $clientesTipos;
    
        return $this;
    }

    /**
     * Get clientesTipos
     *
     * @return \CloudSource\PatoBundle\Entity\ClientesTipos 
     */
    public function getClientesTipos()
    {
        return $this->clientesTipos;
    }

    /**
     * Set criador
     *
     * @param \CloudSource\PatoBundle\Entity\Usuarios $criador
     * @return Clientes
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
     * Set empresa
     *
     * @param \CloudSource\PatoBundle\Entity\Empresas $empresa
     * @return Clientes
     */
    public function setEmpresa(\CloudSource\PatoBundle\Entity\Empresas $empresa = null)
    {
        $this->empresa = $empresa;
    
        return $this;
    }

    /**
     * Get empresa
     *
     * @return \CloudSource\PatoBundle\Entity\Empresas 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}