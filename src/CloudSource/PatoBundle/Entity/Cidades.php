<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cidades
 */
class Cidades
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $cidade;

    /**
     * @var \CloudSource\PatoBundle\Entity\Estados
     */
    private $estado;


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
     * Set cidade
     *
     * @param string $cidade
     * @return Cidades
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    
        return $this;
    }

    /**
     * Get cidade
     *
     * @return string 
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set estado
     *
     * @param \CloudSource\PatoBundle\Entity\Estados $estado
     * @return Cidades
     */
    public function setEstado(\CloudSource\PatoBundle\Entity\Estados $estado = null)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return \CloudSource\PatoBundle\Entity\Estados 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}