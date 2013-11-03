<?php

namespace CloudSource\PatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuarios
 */
class Usuarios implements UserInterface
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
    private $senha;

    /**
     * @var string
     */
    private $salt;

    public function __construct()
    {
        //define salt para encriptar a senha
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
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
     * @return Usuarios
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
     * @return Usuarios
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
     * Set senha
     *
     * @param string $senha
     * @return Usuarios
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    
        return $this;
    }

    /**
     * Get senha
     *
     * @return string 
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuarios
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Retorna salta para encriptar a senha
     *
     * @return string o salt usado para encriptação
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Retorna as permissões de um usuário
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return mixed array Permissões do usuário
     **/
    function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Retorna a senha do usuário para validação
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return string Senha do usuário
     **/
    function getPassword()
    {
        return $this->senha;
    }

    /**
     * Retorna o usuário para autenticação
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     * @return string O usuário para autenticação
     **/
    function getUsername()
    {
        return $this->email;
    }

    /**
     * ??
     *
     * @author Adir Kuhn <adirkuhn@gmail.com>
     * 
     **/
    function eraseCredentials()
    {
    }

    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @param UserInterface $user
     * 
     * @return Boolean
     **/
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof Usuarios) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}