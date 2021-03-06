<?php

namespace BimoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use UserBundle\Entity;

/**
 * MedProto
 *
 * @ORM\Table(name="med_proto")
 * @ORM\Entity(repositoryClass="BimoBundle\Repository\MedProtoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MedProto
{

    /**
     * @ORM\ManyToOne(targetEntity="BimoBundle\Entity\Bimo", inversedBy="medProtos", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bimo;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomBefore", type="string", length=255)
     */
    private $nomBefore;

    /**
     * @var string
     *
     * @ORM\Column(name="dosageBefore", type="string", length=255)
     */
    private $dosageBefore;

    /**
     * @var string
     *
     * @ORM\Column(name="formBefore", type="string", length=255)
     */
    private $formBefore;

    /**
     * @var string
     *
     * @ORM\Column(name="poseBefore", type="string", length=255)
     */
    private $poseBefore;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="dosage", type="string", length=255)
     */
    private $dosage;

    /**
     * @var string
     *
     * @ORM\Column(name="forme", type="string", length=255)
     */
    private $forme;

    /**
     * @var string
     *
     * @ORM\Column(name="poso", type="string", length=255)
     */
    private $poso;

    /**
     * @var string
     *
     * @ORM\Column(name="divergence", type="string", length=255)
     */
    private $divergence;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="divergenceType", type="string", length=255)
     */
    private $divergenceType;

    /**
     * @var string
     *
     * @ORM\Column(name="severity", type="string", length=255)
     */
    private $severity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="proposition", type="text")
     */
    private $proposition;


    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="medStartBefore", type="datetime")
     * @ORM\JoinColumn(nullable=true)
     */
    private $medStartBefore;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="medEndBefore", type="datetime")
     * @ORM\JoinColumn(nullable=true)
     */
    private $medEndBefore;

    /**
    * @ORM\Column(name="dateMedBefore", type="boolean")
    * @ORM\JoinColumn(nullable=true)
    */
    private $dateMedBefore = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="medStartHosp", type="datetime")
     * @ORM\JoinColumn(nullable=true)
     */
    private $medStartHosp;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="medEndHosp", type="datetime")
     * @ORM\JoinColumn(nullable=true)
     */
    private $medEndHosp;

    /**
    * @ORM\Column(name="dateMedHosp", type="boolean")
    * @ORM\JoinColumn(nullable=true)
    */
    private $dateMedHosp = false;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \Datetime();

        $this->medStartBefore = new \Datetime();
        $this->medEndBefore = new \Datetime();
        $this->medStartHosp = new \Datetime();
        $this->medEndHosp = new \Datetime();
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
     * Set nomBefore
     *
     * @param string $nomBefore
     *
     * @return MedProto
     */
    public function setNomBefore($nomBefore)
    {
        $this->nomBefore = $nomBefore;

        return $this;
    }

    /**
     * Get nomBefore
     *
     * @return string
     */
    public function getNomBefore()
    {
        return $this->nomBefore;
    }

    /**
     * Set dosageBefore
     *
     * @param string $dosageBefore
     *
     * @return MedProto
     */
    public function setDosageBefore($dosageBefore)
    {
        $this->dosageBefore = $dosageBefore;

        return $this;
    }

    /**
     * Get dosageBefore
     *
     * @return string
     */
    public function getDosageBefore()
    {
        return $this->dosageBefore;
    }

    /**
     * Set formBefore
     *
     * @param string $formBefore
     *
     * @return MedProto
     */
    public function setFormBefore($formBefore)
    {
        $this->formBefore = $formBefore;

        return $this;
    }

    /**
     * Get formBefore
     *
     * @return string
     */
    public function getFormBefore()
    {
        return $this->formBefore;
    }

    /**
     * Set poseBefore
     *
     * @param string $poseBefore
     *
     * @return MedProto
     */
    public function setPoseBefore($poseBefore)
    {
        $this->poseBefore = $poseBefore;

        return $this;
    }

    /**
     * Get poseBefore
     *
     * @return string
     */
    public function getPoseBefore()
    {
        return $this->poseBefore;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return MedProto
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
     * Set dosage
     *
     * @param string $dosage
     *
     * @return MedProto
     */
    public function setDosage($dosage)
    {
        $this->dosage = $dosage;

        return $this;
    }

    /**
     * Get dosage
     *
     * @return string
     */
    public function getDosage()
    {
        return $this->dosage;
    }

    /**
     * Set forme
     *
     * @param string $forme
     *
     * @return MedProto
     */
    public function setForme($forme)
    {
        $this->forme = $forme;

        return $this;
    }

    /**
     * Get forme
     *
     * @return string
     */
    public function getForme()
    {
        return $this->forme;
    }

    /**
     * Set poso
     *
     * @param string $poso
     *
     * @return MedProto
     */
    public function setPoso($poso)
    {
        $this->poso = $poso;

        return $this;
    }

    /**
     * Get poso
     *
     * @return string
     */
    public function getPoso()
    {
        return $this->poso;
    }

    /**
     * Set divergence
     *
     * @param string $divergence
     *
     * @return MedProto
     */
    public function setDivergence($divergence)
    {
        $this->divergence = $divergence;

        return $this;
    }

    /**
     * Get divergence
     *
     * @return string
     */
    public function getDivergence()
    {
        return $this->divergence;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return MedProto
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set divergenceType
     *
     * @param string $divergenceType
     *
     * @return MedProto
     */
    public function setDivergenceType($divergenceType)
    {
        $this->divergenceType = $divergenceType;

        return $this;
    }

    /**
     * Get divergenceType
     *
     * @return string
     */
    public function getDivergenceType()
    {
        return $this->divergenceType;
    }

    /**
     * Set severity
     *
     * @param string $severity
     *
     * @return MedProto
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;

        return $this;
    }

    /**
     * Get severity
     *
     * @return string
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return MedProto
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
     * Set proposition
     *
     * @param string $proposition
     *
     * @return MedProto
     */
    public function setProposition($proposition)
    {
        $this->proposition = $proposition;

        return $this;
    }

    /**
     * Get proposition
     *
     * @return string
     */
    public function getProposition()
    {
        return $this->proposition;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return MedProto
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set bimo
     *
     * @param \BimoBundle\Entity\Bimo $bimo
     *
     * @return MedProto
     */
    public function setBimo(\BimoBundle\Entity\Bimo $bimo = null)
    {
        $this->bimo = $bimo;

        return $this;
    }

    /**
     * Get bimo
     *
     * @return \BimoBundle\Entity\Bimo
     */
    public function getBimo()
    {
        return $this->bimo;
    }

    /**
     * Set medStartBefore
     *
     * @param \DateTime $medStartBefore
     *
     * @return MedProto
     */
    public function setMedStartBefore($medStartBefore) /// **********DEBUT
    {
        $this->medStartBefore = $medStartBefore;

        return $this;
    }

    /**
     * Get medStartBefore
     *
     * @return \DateTime
     */
    public function getMedStartBefore()
    {
        return $this->medStartBefore;
    }

    /**
     * Set medEndBefore
     *
     * @param \DateTime $medEndBefore
     *
     * @return MedProto
     */
    public function setMedEndBefore($medEndBefore)
    {
        $this->medEndBefore = $medEndBefore;

        return $this;
    }

    /**
     * Get medEndBefore
     *
     * @return \DateTime
     */
    public function getMedEndBefore()
    {
        return $this->medEndBefore;
    }

    /**
     * Set dateMedBefore
     *
     * @param boolean $dateMedBefore
     *
     * @return MedProto
     */
    public function setDateMedBefore($dateMedBefore)
    {
        $this->dateMedBefore = $dateMedBefore;

        return $this;
    }

    /**
     * Get dateMedBefore
     *
     * @return boolean
     */
    public function getDateMedBefore()
    {
        return $this->dateMedBefore;
    }

    /**
     * Set medStartHosp
     *
     * @param \DateTime $medStartHosp
     *
     * @return MedProto
     */
    public function setMedStartHosp($medStartHosp)
    {
        $this->medStartHosp = $medStartHosp;

        return $this;
    }

    /**
     * Get medStartHosp
     *
     * @return \DateTime
     */
    public function getMedStartHosp()
    {
        return $this->medStartHosp;
    }

    /**
     * Set medEndHosp
     *
     * @param \DateTime $medEndHosp
     *
     * @return MedProto
     */
    public function setMedEndHosp($medEndHosp)
    {
        $this->medEndHosp = $medEndHosp;

        return $this;
    }

    /**
     * Get medEndHosp
     *
     * @return \DateTime
     */
    public function getMedEndHosp() 
    {
        return $this->medEndHosp;
    }

    /**
     * Set dateMedHosp
     *
     * @param boolean $dateMedHosp
     *
     * @return MedProto
     */
    public function setDateMedHosp($dateMedHosp)
    {
        $this->dateMedHosp = $dateMedHosp;

        return $this;
    }

    /**
     * Get dateMedHosp
     *
     * @return boolean
     */
    public function getDateMedHosp()
    {
        return $this->dateMedHosp;
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
     * @return MedProto
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
