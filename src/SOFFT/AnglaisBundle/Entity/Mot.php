<?php

namespace SOFFT\AnglaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SOFFT\AnglaisBundle\Entity\User;
use \DateTime;
use Symfony\Component\Validator\ExecutionContext;

/**
 * SOFFT\AnglaisBundle\Entity\Mot
 */
class Mot
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

    /**
     * @var string $fr
     */
    private $fr = '';

    /**
     * @var string $en
     */
    private $en = '';

    /**
     * @var string $explication
     */
    private $explication = ''; 

    /**
     * @var datetime $cadenas
     */
    private $cadenas;
    
    const DUREE_CADENAS = 60;
    const DUREE_CADENAS_INTERVAL = 'PT60S';
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fr
     *
     * @param string $fr
     */
    public function setFr($fr)
    {
        if ($fr === NULL) 
            $this->fr = '' ;
        else
            $this->fr = trim($fr);
    }

    /**
     * Get fr
     *
     * @return string 
     */
    public function getFr()
    {
        return $this->fr;
    }

    /**
     * Set en
     *
     * @param string $en
     */
    public function setEn($en)
    {
        if ($en === NULL)
            $this->en = '';
        else
            $this->en = trim($en);
    }

    /**
     * Get en
     *
     * @return string 
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Set explication
     *
     * @param string $explication
     */
    public function setExplication($explication)
    {
        if ($explication === NULL) {
            $this->explication = '';
        }
        else {
            $this->explication = $explication;
        }
    }

    /**
     * Get explication
     *
     * @return string 
     */
    public function getExplication()
    {
        return $this->explication;
    }
    
    public function cadenas(User $user ) {
        $this->setCadenas(new DateTime());
        $this->setCadenaswho($user);
    }
    
    public function resetCadenas() {
        $this->setCadenas(NULL);
        $this->setCadenaswho(NULL);
    }

    /**
     * Set cadenas
     *
     * @param datetime $cadenas
     */
    private function setCadenas($cadenas)
    {
        $this->cadenas = $cadenas;
    }

    /**
     * Get cadenas
     *
     * @return datetime 
     */
    public function getCadenas()
    {
        return $this->cadenas;
    }
    
    
    /**
     * @var SOFFT\AnglaisBundle\Entity\User
     */
    private $cadenaswho;


    /**
     * Set cadenaswho
     *
     * @param SOFFT\AnglaisBundle\Entity\User $cadenaswho
     */
    private function setCadenaswho($cadenaswho)
    {
        $this->cadenaswho = $cadenaswho;
    }

    /**
     * Get cadenaswho
     *
     * @return SOFFT\AnglaisBundle\Entity\User 
     */
    public function getCadenaswho()
    {
        return $this->cadenaswho;
    }
    
    public function isBeingCadenas() {
        
        if ($this->getCadenas() === NULL )
            return false;
        else 
        {
            $ouvertLimitBefore = new DateTime();
            $dateInterval = new \DateInterval(self::DUREE_CADENAS_INTERVAL);
            $ouvertLimitBefore = $ouvertLimitBefore->sub($dateInterval);
            if ( $this->getCadenas() < $ouvertLimitBefore ) 
            {
                return false;
            } else 
            {
                return true;
            }
            
        }
            
    }
    
    public function isValid(ExecutionContext $context){
        if ($this->getEn() === '' && $this->getFr() === '') {
            $propertyPath = $context->getPropertyPath() . '.fr';
            $context->setPropertyPath($propertyPath);
            $context->addViolation('Veuillez remplir un des deux mots: l\'anglais ou le français', array(), null);
        }
    }


    /**
     * Add tags
     *
     * @param \SOFFT\AnglaisBundle\Entity\Tag $tags
     * @return Mot
     */
    public function addTag(\SOFFT\AnglaisBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \SOFFT\AnglaisBundle\Entity\Tag $tags
     */
    public function removeTag(\SOFFT\AnglaisBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
