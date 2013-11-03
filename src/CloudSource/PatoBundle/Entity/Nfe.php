<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nfe
 */
class Nfe
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