<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oportunidades
 */
class Oportunidades
{
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}