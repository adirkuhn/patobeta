<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Auditoria
 */
class Auditoria
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