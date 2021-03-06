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

    /**
     * @var string
     *
     * @ORM\Column(name="birthDay", type="string", length=255, nullable = true)
     */
    private $birthDay;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable = true)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255, nullable = true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="socialSecurityNumber", type="string", length=255, nullable = true)
     */
    private $socialSecurityNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable = true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="doctor", type="string", length=255, nullable = true)
     */
    private $doctor;

    /**
     * @var string
     *
     * @ORM\Column(name="bloodGroup", type="string", length=255, nullable = true)
     */
    private $bloodGroup;


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

    /**
     * Set birthDay.
     *
     * @param string $birthDay
     *
     * @return Patient
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    /**
     * Get birthDay.
     *
     * @return string
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    /**
     * Set adress.
     *
     * @param string $adress
     *
     * @return Patient
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress.
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set phoneNumber.
     *
     * @param string $phoneNumber
     *
     * @return Patient
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set socialSecurityNumber.
     *
     * @param string $socialSecurityNumber
     *
     * @return Patient
     */
    public function setSocialSecurityNumber($socialSecurityNumber)
    {
        $this->socialSecurityNumber = $socialSecurityNumber;

        return $this;
    }

    /**
     * Get socialSecurityNumber.
     *
     * @return string
     */
    public function getSocialSecurityNumber()
    {
        return $this->socialSecurityNumber;
    }

    /**
     * Set mail.
     *
     * @param string $mail
     *
     * @return Patient
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail.
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set doctor.
     *
     * @param string $doctor
     *
     * @return Patient
     */
    public function setDoctor($doctor)
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * Get doctor.
     *
     * @return string
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * Set bloodGroup.
     *
     * @param string $bloodGroup
     *
     * @return Patient
     */
    public function setBloodGroup($bloodGroup)
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    /**
     * Get bloodGroup.
     *
     * @return string
     */
    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }
}
