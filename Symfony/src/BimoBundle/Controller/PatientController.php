<?php

namespace BimoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use BimoBundle\Entity\MedProto;
use BimoBundle\Entity\Patient;

use BimoBundle\Form\MedProtoType ;
use BimoBundle\Form\PatientType ;
use BimoBundle\Form\PatientEditType ;
use BimoBundle\Form\PatientSearchType ;

class PatientController extends Controller
{


    public function AddAction(Request $request)
    {

    	$patient = new Patient();

	    $form = $this
	    	->get('form.factory')
	    	->create(PatientType::class, $patient);

 		$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) 
	   	 {
	    		
			// $nouveauNom = $form["prenom"]->getData();
			// $patient->setNom($nouveauNom);

			$em = $this->getDoctrine()->getManager();
			$em->persist($patient);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Patient bien enregistrée.');

			return $this->render('BimoBundle:Patient:viewPatient.html.twig', array(
	      		'patient' => $patient,
	      		'idBimo' => null ,
	  		));

				// , array('id' => $patient->getId()));
	    }

	    return $this->render('BimoBundle:Patient:addPatient.html.twig', array(
	      'form' => $form->createView(),
	    ));

    }

    public function EditAction($id, Request $request)
    {
    	
 		$patient = $this
	    	->getDoctrine()
	      	->getManager()
	      	->getRepository('BimoBundle:Patient')
	      	->find($id)
	    ;
	    $form = $this
	    	->get('form.factory')
	    	->create(PatientEditType::class, $patient);

	    if ($request->isMethod('POST') &&
	    	$form->handleRequest($request)->isValid()) 
	    {

			$em = $this->getDoctrine()->getManager();
			$em->persist($patient);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'profil du patient bien modifié.');

			return $this->render('BimoBundle:Patient:viewPatient.html.twig', array(
	      		'patient' => $patient,
	      		'idBimo' => null ,
	  		));

				// , array('id' => $patient->getId()));
	    }

	    return $this->render('BimoBundle:Patient:editPatient.html.twig', array(
	      'form' => $form->createView(),
	      'patient' => $patient,
	    ));

    }


    public function listAction(Request $request, $page)
	{
	    if ($page < 1) {
	      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
	    }

	    $em = $this->getDoctrine()
	    	->getManager()
	    	->getRepository('BimoBundle:Patient')
	    ;

	    $nbPerPage = 15 ;
	    $listPatient = $em->getPatients($page, $nbPerPage);

	    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces

    	$nbPages = ceil(count($listPatient) / $nbPerPage);

   		// Si la page n'existe pas, on retourne une 404
    	if ($page > $nbPages) {
      		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    	}

    	$patient = new Patient();
    	$form = $this
	    	->get('form.factory')
	    	->create(PatientSearchType::class, $patient);

 		$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) 
	   	{
	   		$search = $form["nom"]->getData();
	   		$em = $this->getDoctrine()
		    	->getManager()
		    	->getRepository('BimoBundle:Patient')
		    ;
		    $listPatient = $em->getPatientsFormSearch($search, $page, $nbPerPage);

			return $this->render('BimoBundle:Patient:listPatientAfterSearch.html.twig', array(
	      		'listPatient' => $listPatient,
		        'page' => $page,
			    'nbPages' => $nbPages,
			    'search' => $search,
	  		));
	    }

	    // Et modifiez le 2nd argument pour injecter notre liste
	    return $this->render('BimoBundle:Patient:listPatient.html.twig', array(
	      'form' => $form->createView(),	
	      'listPatient' => $listPatient,
	      'page' => $page,
	      'nbPages' => $nbPages
	    ));

	}

	public function viewPatientAction($id, $idBimo=null)
    {
	    $em = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('BimoBundle:Patient')
	    ;
	    $patient = $em->find($id);

	    if (null === $patient) {
	      throw new NotFoundHttpException("La patient d'id ".$id." n'existe pas.");
    	}

    	//$patientNameConverter = $this->container->get('bimo.patientNameConverter');


    	$lastBimo = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('BimoBundle:Bimo')
	      ->getLastBimoOfPatient($id);
	    ;

	    // Le render ne change pas, on passait avant un tableau, maintenant un objet
	    return $this->render('BimoBundle:Patient:viewPatient.html.twig', array(
	      'patient' => $patient,
	      'idBimo' => $idBimo,
	      '$lastBimo' => $lastBimo,
	    ));
    }

    public function deletePatientAction(Request $request, $id)
  	{
	    $em = $this->getDoctrine()->getManager();

	    $patient = $em
	    	->getRepository('BimoBundle:Patient')
	    	->find($id);

	    if (null === $patient) {
	      throw new NotFoundHttpException("Le patient d'id ".$id." n'existe pas.");
	    }
	    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
	    // Cela permet de protéger la suppression d'annonce contre cette faille
	    $form = $this->get('form.factory')->create();

	    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em->remove($patient);
	      $em->flush();

	      $request->getSession()->getFlashBag()->add('info', "Le patient a bien été supprimée.");

	      return $this->redirectToRoute('listPatient');
	    }
	    
	    return $this->render('BimoBundle:Patient:deletePatient.html.twig', array(
	      'patient' => $patient,
	      'form'   => $form->createView(),
	    ));
    } 

}
