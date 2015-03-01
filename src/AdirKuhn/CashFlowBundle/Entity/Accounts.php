<?php

namespace AdirKuhn\CashFlowBundle\Entity;

use AdirKuhn\ClientsBundle\Entity\Company;
use Doctrine\ORM\Mapping as ORM;

/**
 * Accounts
 */
class Accounts
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $paidAt;

    /**
     * @var \DateTime
     */
    private $dueDate;


    /**
     * @var double
     */
    private $value;

    /**
     * @var Company
     */
    private $company;


    public function __construct()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $this->dueDate = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $this->paidAt = null;
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
     * Set type
     *
     * @param integer $type
     * @return Accounts
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return Accounts
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Accounts
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Accounts
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set paidAt
     *
     * @return Accounts
     */
    public function setPaidAt($paidAt)
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    /**
     * Get paidAt
     *
     * @return \DateTime $paidAt
     */
    public function getPaidAt()
    {
        return $this->paidAt;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Accounts
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set Value
     *
     * @param double $value
     *
     * @return Accounts
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get Value
     *
     * return double $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set Company
     *
     * @param Company company
     *
     * @return Accounts
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get Company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
