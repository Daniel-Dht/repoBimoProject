<?php

namespace BimoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * BimoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BimoRepository extends \Doctrine\ORM\EntityRepository
{
	public function getBimos($page,$nbPerPage) 
	{

	    $query = $this
	    	->createQueryBuilder('b')
	    	->leftJoin('b.medProtos','m')
			->addSelect('m')
			->leftJoin('b.patient','p')
			->addSelect('p')
			->orderBy('b.date', 'DESC')
	    ;

	    $query
	    // On définit l'annonce à partir de laquelle commencer la liste
	    	->setFirstResult(($page-1) * $nbPerPage)
	    // Ainsi que le nombre d'annonce à afficher sur une page
	    	->setMaxResults($nbPerPage)
	    ;

	    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
	    // (n'oubliez pas le use correspondant en début de fichier)
	    return new Paginator($query, true);
	}
	public function getBimosOfPatient($idPatient) 
	{

	    $query = $this
	    	->createQueryBuilder('b')
	    	->leftJoin('b.patient','p')
			->addSelect('p')
			->where('p.id = :id')
    		->setParameter('id', $idPatient)
			->orderBy('b.date', 'DESC')
	    ;

	    return $query
			->getQuery()
			->getResult()
		;

	
	}
	public function getLastBimoOfPatient($idPatient)
	{
	    $query = $this
	    	->createQueryBuilder('b')
	    	->leftJoin('b.patient','p')
			->addSelect('p')
			->where('p.id = :id')
    		->setParameter('id', $idPatient)
			->addselect('MAX(b.id)')
			
	    ;
	    return $query
			->getQuery()
			->getResult()
		;
	}
	public function getUrgentBimos($page,$nbPerPage) 
	{

	    $query = $this
	    	->createQueryBuilder('b')
	    	->where('b.urgency = True')
	    	->leftJoin('b.medProtos','m')
			->addSelect('m')
			->leftJoin('b.patient','p')
			->addSelect('p')
			->orderBy('b.date', 'DESC')
	    ;

	    $query
	    // On définit l'annonce à partir de laquelle commencer la liste
	    	->setFirstResult(($page-1) * $nbPerPage)
	    // Ainsi que le nombre d'annonce à afficher sur une page
	    	->setMaxResults($nbPerPage)
	    ;

	    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
	    // (n'oubliez pas le use correspondant en début de fichier)
	    return new Paginator($query, true);
	}

	public function getBimoFromHosp(\BimoBundle\Entity\Hosp $hosp) 
	{
	    $query = $this
	    	->createQueryBuilder('b')
	    	->andWhere('b.patient = :hospPatient')
	    	->andWhere('b.date > :hospStartDate')
	    	->andwhere('b.date < :hospReleaseDate')
	    	->setParameter('hospPatient', $hosp->getPatient() )
	    	->setParameter('hospStartDate', $hosp->getStartDate())
	    	->setParameter('hospReleaseDate', $hosp->getReleaseDate())
	    ;
	    return $query
			->getQuery()
			->getResult()
		;
	}
}
