<?php

namespace SOFFT\AnglaisBundle\Security\Provider;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use CL\PersonaUserBundle\Security\UserProvider\PersonaUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use CL\PersonaUserBundle\Security\Provider\PersonaIdNotExistingException;

/**
 * 
 *
 * @author julienfastre
 */
class UserProvider implements PersonaUserProviderInterface {
    
    private $em;
    
    private $session;
    
    
    public function __construct(EntityManagerInterface $em, Session $session) {
        $this->em = $em;
        $this->session = $session;
    }
    
    
    
    public function loadUserByPersonaId($personaId) {
        $user = $this->em->getRepository('SOFFTAnglaisBundle:User')
                ->findOneBy(array('personaId' => $personaId));
        
        if ($user === null) {
            throw new UsernameNotFoundException($personaId);
        }
        
        
        return $user;
    }

    public function loadUserByUsername($username) {
        $user = $this->em->getRepository('SOFFTAnglaisBundle:User')
                ->findBy(array('username' => $username));
        
        if ($user === null) {
            throw new UsernameNotFoundException("The user with username "
                    . $username . " is not found");
        }
        
        
        return $user;
    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user) {
        if ( ! $this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException('class '.get_class($user).
                  " is not supported by ".get_class($this));
        }
        
        try {
            return $this->em->getRepository('SOFFTAnglaisBundle:User')
                  ->find($user->getId());
        } catch (\Exception $e) {
            throw new \Exception("problem on refreshing user ", 1000, $e);
        }
    }

    public function supportsClass($class) {
        return $class === 'SOFFT\AnglaisBundle\Entity\User';
    }

}
