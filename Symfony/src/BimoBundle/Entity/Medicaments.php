<?php

namespace BimoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medicaments
 *
 * @ORM\Table(name="medicaments")
 * @ORM\Entity(repositoryClass="BimoBundle\Repository\MedicamentsRepository")
 */
class Medicaments
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
     * @var string
     *
     * @ORM\Column(name="medoc", type="text")
     */
    private $medoc;


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
     * Set medoc
     *
     * @param string $medoc
     *
     * @return Medicaments
     */
    public function setMedoc($medoc)
    {
        $this->medoc = $medoc;

        return $this;
    }

    /**
     * Get medoc
     *
     * @return string
     */
    public function getMedoc()
    {
        return $this->medoc;
    }
}

