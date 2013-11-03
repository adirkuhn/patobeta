<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estados
 */
class Estados
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var \CloudSource\PatoBundle\Entity\Paises
     */
    private $pais;


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
     * Set estado
     *
     * @param string $estado
     * @return Estados
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set pais
     *
     * @param \CloudSource\PatoBundle\Entity\Paises $pais
     * @return Estados
     */
    public function setPais(\CloudSource\PatoBundle\Entity\Paises $pais = null)
    {
        $this->pais = $pais;
    
        return $this;
    }

    /**
     * Get pais
     *
     * @return \CloudSource\PatoBundle\Entity\Paises 
     */
    public function getPais()
    {
        return $this->pais;
    }
}