<?php

namespace BimoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hosp
 *
 * @ORM\Table(name="hosp")
 * @ORM\Entity(repositoryClass="BimoBundle\Repository\HospRepository")
 */
class Hosp
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
     * @ORM\ManyToOne(targetEntity="BimoBundle\Entity\Patient", inversedBy="hosps", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $patient;   

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="datetime")
     */
    private $releaseDate;

    /**
    * @ORM\Column(name="active", type="boolean")
    */
    private $active = true;


public function __construct()
    {
        $this->startDate = new \Datetime();
        $this->releaseDate = new \Datetime();
        $this->setActive = True ;
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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Hosp
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Hosp
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set patient
     *
     * @param \BimoBundle\Entity\Patient $patient
     *
     * @return Hosp
     */
    public function setPatient(\BimoBundle\Entity\Patient $patient)
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Hosp
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}
