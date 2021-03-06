<?php

namespace BimoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PatientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PatientRepository extends \Doctrine\ORM\EntityRepository
{
	public function getPatients($page,$nbPerPage)
  	{
	    $query = $this
	    	->createQueryBuilder('p')
			->orderBy('p.date', 'DESC')
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

	public function getPatientsFormSearch($searchName,$page,$nbPerPage) 
	{

	    $query = $this
	    	->createQueryBuilder('p')
			->where('p.prenom LIKE :prenom')
			->orWhere('p.nom LIKE :nom')
			->setParameter('prenom', '%'.$searchName.'%')
			->setParameter('nom', '%'.$searchName.'%')
	    ;

		$query
	    	->setFirstResult(($page-1) * $nbPerPage)
	    	->setMaxResults($nbPerPage)
	    ;
	    return new Paginator($query, true);	
	}
}
