<?php

namespace AdirKuhn\PatoCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 */
class Roles
{
    private $permissions = array(
        'READ'   => 'R',
        'WRITE'  => 'W',
        'UPDATE' => 'U',
        'DELETE' => 'D',
        'ADMIN'  => 'A',

        'R' => 'READ',
        'W' => 'WRITE',
        'U' => 'UPDATE',
        'D' => 'DELETE',
        'A' => 'ADMIN'
    );

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $role;

    /**
     * @var User
     */
    private $user;

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
     * Set entity
     *
     * @param string $entity
     * @return Roles
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Roles
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Roles
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get Role Name
     *
     * @return string Role name
     */
    public function getRoleName()
    {
        $roleName = 'ROLE_' . $this->entity . '_' . $this->permissions[$this->role];
        return strtoupper($roleName);
    }
}
