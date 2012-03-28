<?php

namespace SOFFT\AnglaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var string $fr
     */
    private $fr;

    /**
     * @var string $en
     */
    private $en;

    /**
     * @var string $explication
     */
    private $explication;

    /**
     * @var datetime $cadenas
     */
    private $cadenas;


    /**
     * Set fr
     *
     * @param string $fr
     */
    public function setFr($fr)
    {
        $this->fr = $fr;
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
        $this->en = $en;
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
        $this->explication = $explication;
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

    /**
     * Set cadenas
     *
     * @param datetime $cadenas
     */
    public function setCadenas($cadenas)
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

    public function __construct()
    {
        $this->cadenaswho = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add cadenaswho
     *
     * @param SOFFT\AnglaisBundle\Entity\User $cadenaswho
     */
    public function addUser(\SOFFT\AnglaisBundle\Entity\User $cadenaswho)
    {
        $this->cadenaswho[] = $cadenaswho;
    }

    /**
     * Get cadenaswho
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCadenaswho()
    {
        return $this->cadenaswho;
    }
}