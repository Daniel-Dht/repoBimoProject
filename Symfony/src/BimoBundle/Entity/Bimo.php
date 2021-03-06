<?php

namespace BimoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Bimo
 *
 * @ORM\Table(name="bimo")
 * @ORM\Entity(repositoryClass="BimoBundle\Repository\BimoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Bimo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BimoBundle\Entity\Patient", inversedBy="bimos", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $patient;

    /**
     * @ORM\OneToMany(targetEntity="BimoBundle\Entity\MedProto", mappedBy="bimo", cascade={"persist"},orphanRemoval=true)
     */
    private $medProtos; 


    /**
     * @var bool
     *
     * @ORM\Column(name="urgency", type="boolean")
     */
    protected $urgency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->date = new \Datetime();
        $this->medProtos = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set urgency
     *
     * @param boolean $urgency
     *
     * @return Bimo
     */
    public function setUrgency($urgency)
    {
        $this->urgency = $urgency;

        return $this;
    }

    /**
     * Get urgency
     *
     * @return bool
     */
    public function getUrgency()
    {
        return $this->urgency;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Bimo
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set patient
     *
     * @param \BimoBundle\Entity\Patient $patient
     *
     * @return Bimo
     */
    public function setPatient(\BimoBundle\Entity\Patient $patient = null)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get patient
     *
     * @return \BimoBundle\Entity\Patient
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Bimo
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add medProto
     *
     * @param \BimoBundle\Entity\MedProto $medProto
     *
     * @return Bimo
     */
    public function addMedProto(\BimoBundle\Entity\MedProto $medProto)
    {
        $this->medProtos[] = $medProto;

        $medProto->setBimo($this);

        return $this;
    }

    /**
     * Remove medProto
     *
     * @param \BimoBundle\Entity\MedProto $medProto
     */
    public function removeMedProto(\BimoBundle\Entity\MedProto $medProto)
    {
        $this->medProtos->removeElement($medProto);
    }

    /**
     * Get medProtos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedProtos()
    {
        return $this->medProtos;
    }

    /**
    * @ORM\PreUpdate
    */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
    }


    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Bimo
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;


        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
