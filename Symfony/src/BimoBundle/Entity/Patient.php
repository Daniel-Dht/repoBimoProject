<?php

namespace BimoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Patient
 *
 * @ORM\Table(name="patient")
 * @ORM\Entity(repositoryClass="BimoBundle\Repository\PatientRepository")
 */
class Patient
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
     * @ORM\OneToMany(targetEntity="BimoBundle\Entity\Bimo", mappedBy="patient", cascade={"persist"},orphanRemoval=true)
     */
    private $bimos; 

    /**
     * @ORM\OneToMany(targetEntity="BimoBundle\Entity\Hosp", mappedBy="patient", cascade={"persist"},orphanRemoval=true)
     */
    private $hosps; 

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \Datetime();
        $this->bimos = new ArrayCollection();
        $this->hosps = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Patient
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Patient
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Patient
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
     * Add bimo
     *
     * @param \BimoBundle\Entity\Bimo $bimo
     *
     * @return Patient
     */
    public function addBimo(\BimoBundle\Entity\Bimo $bimo)
    {
        $this->bimos[] = $bimo;

        return $this;
    }

    /**
     * Remove bimo
     *
     * @param \BimoBundle\Entity\Bimo $bimo
     */
    public function removeBimo(\BimoBundle\Entity\Bimo $bimo)
    {
        $this->bimos->removeElement($bimo);
    }

    /**
     * Get bimos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBimos()
    {
        return $this->bimos;
    }

    /**
     * Add hosp
     *
     * @param \BimoBundle\Entity\Hosp $hosp
     *
     * @return Patient
     */
    public function addHosp(\BimoBundle\Entity\Hosp $hosp)
    {
        $this->hosps[] = $hosp;
        return $this;
    }

    /**
     * Remove hosp
     *
     * @param \BimoBundle\Entity\Hosp $hosp
     */
    public function removeHosp(\BimoBundle\Entity\Hosp $hosp)
    {
        $this->hosps->removeElement($hosp);
    }

    /**
     * Get hosps
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHosps()
    {
        return $this->hosps;
    }
}
