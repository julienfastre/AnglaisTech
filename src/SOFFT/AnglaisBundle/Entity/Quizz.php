<?php

namespace SOFFT\AnglaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SOFFT\AnglaisBundle\Entity\Quizz
 */
class Quizz
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var datetime $creationDate
     */
    private $creationDate;

    /**
     * @var string $note
     */
    private $note = '';

    /**
     * @var SOFFT\AnglaisBundle\Entity\User
     */
    private $owner;

    /**
     * @var SOFFT\AnglaisBundle\Entity\Mot
     */
    private $mots;
    
     /**
     * @var integer $type
     */
    private $type;
    
    const DRAG_AND_DROP1 = 1;

    public function __construct($type)
    {
        $this->mots = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreationDate(new \DateTime());
        $this->setType($type);
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
     * Set creationDate
     *
     * @param datetime $creationDate
     */
    private function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * Get creationDate
     *
     * @return datetime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set note
     *
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }


    /**
     * Get owner
     *
     * @return SOFFT\AnglaisBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add mots
     *
     * @param SOFFT\AnglaisBundle\Entity\Mot $mots
     */
    public function addMot(\SOFFT\AnglaisBundle\Entity\Mot $mots)
    {
        $this->mots[] = $mots;
    }

    /**
     * Get mots
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMots()
    {
        return $this->mots;
    }

    /**
     * Set owner
     *
     * @param SOFFT\AnglaisBundle\Entity\User $owner
     */
    public function setOwner(\SOFFT\AnglaisBundle\Entity\User $owner)
    {
        $this->owner = $owner;
    }


    /**
     * Set type
     *
     * @param integer $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
}