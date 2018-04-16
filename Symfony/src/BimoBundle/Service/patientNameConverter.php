<?php
// src/BimoBundle/Service/PatientNameConverter.php

namespace BimoBundle\Service;

class PatientNameConverter
{
  /**
   * Vérifie si le texte est un spam ou non
   *
   * @param string $text
   * @return bool
   */
  public function isSpam($text)
  {
    return strlen($text) < 50;
  }
}