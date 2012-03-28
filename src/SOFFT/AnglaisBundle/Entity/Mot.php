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
    private function setCadenaswho(\SOFFT\AnglaisBundle\Entity\User $cadenaswho)
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
}