<?php
// src/OC/PlatformBundle/Entity/UserBimo.php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="userBimo")
 */
class UserBimo
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="BimoBundle\Entity\Bimo")
   * @ORM\JoinColumn(nullable=false)
   */
  private $bimo;

  /**
   * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
   * @ORM\JoinColumn(nullable=false)
   */
  private $User;

  /**
   * @ORM\Column(name="updated_at", type="datetime", nullable=true)
   */
  protected $updatedAt;

  public function __construct()
  {
      $this->updatedAt = new \Datetime();
  }

  /**
   * Get id.
   *
   * @return int
   */
  public function getId()
  {
      return $this->id;
  }

  /**
   * Set updatedAt.
   *
   * @param \DateTime|null $updatedAt
   *
   * @return UserBimo
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

  /**
   * Set bimo.
   *
   * @param \BimoBundle\Entity\Bimo $bimo
   *
   * @return UserBimo
   */
  public function setBimo(\BimoBundle\Entity\Bimo $bimo)
  {
      $this->bimo = $bimo;

      return $this;
  }

  /**
   * Get bimo.
   *
   * @return \BimoBundle\Entity\Bimo
   */
  public function getBimo()
  {
      return $this->bimo;
  }

  /**
   * Set user.
   *
   * @param \UserBundle\Entity\User $user
   *
   * @return UserBimo
   */
  public function setUser(User $user)
  {
      $this->User = $user;

      return $this;
  }

  /**
   * Get user.
   *
   * @return \UserBundle\Entity\User
   */
  public function getUser()
  {
      return $this->User;
  }

  /**
   * update
   */
  public function updateDate()
  {
      $this->setUpdatedAt(new \Datetime());
  }

}
