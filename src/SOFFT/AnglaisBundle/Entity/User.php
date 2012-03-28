<?php

namespace SOFFT\AnglaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * SOFFT\AnglaisBundle\Entity\User
 */
class User implements UserInterface
{
    /**
     * @var integer $id
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
    /**
     * @var string $username
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;


    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function equals(UserInterface $user) {
        if ($user->getUsername() == $this->getUsername())
            return true;
        else
            return false;
        
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return array('ROLE_USER');
        
    }

    public function getSalt() {
        return 'salt';
        
    }
}