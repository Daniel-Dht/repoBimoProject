<?php

namespace BimoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use BimoBundle\Entity\MedProto;
use BimoBundle\Entity\Patient;
use BimoBundle\Entity\Bimo;
use BimoBundle\Entity\Hosp;

use BimoBundle\Form\MedProtoType ;
use BimoBundle\Form\BimoType ;
use BimoBundle\Form\BimoEditType ;
use BimoBundle\Form\BimoPatientType ;

use BimoBundle\Form\HospType ;

class HospController extends Controller
{
	public function AddHospAction(Request $request, $idPatient)
    {
    	
	 	$patient = $this
		    	->getDoctrine()
		      	->getManager()
		      	->getRepository('BimoBundle:Patient')
		      	->find($idPatient);
		// On active toutes les hospitalisations précédentes à 0, avec une realiseDate à ajd.
		foreach ($patient->getHosps() as $hosp) {
			if ($hosp->getActive() == True) {
				$hosp->setActive(False);
				$hosp->setReleaseDate(new \Datetime() );
			}
		}
		$hosp = new Hosp();
		$hosp->setPatient($patient);
		$patient->addHosp($hosp);

	    $form = $this
	    	->get('form.factory')
	    	->create(HospType::class, $hosp);
 		$form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) 
	    {

			$em = $this->getDoctrine()->getManager();
			$em->persist($hosp);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'hospitalisation bien enregistrée.');

			return $this->render('BimoBundle:Patient:viewPatient.html.twig', array(
	      		'patient' => $patient,
	      		'idBimo' => null ,
	  		));
	    }
	    return $this->render('BimoBundle:Hosp:addHosp.html.twig', array(
	      'form' => $form->createView(),
	      'patient' => $patient,
	    ));
    }	

    public function deleteHospAction(Request $request, $id)
  	{
	    $em = $this->getDoctrine()->getManager();

	    $hosp = $em
	    	->getRepository('BimoBundle:Hosp')
	    	->find($id);

	   	if (null === $hosp) {
	      throw new NotFoundHttpException("L'hospitalisation d'id ".$id." n'existe pas.");
	    }

	    $patient = $hosp->getPatient();
	   	if (null === $patient) {
	      throw new NotFoundHttpException("Le patient lié à l'hospitalisation d'id ".$id." n'existe pas.");
	    }
	    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
	    // Cela permet de protéger la suppression d'annonce contre cette faille
	    $form = $this->get('form.factory')->create();

	    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em->remove($hosp);
	     // $patient->removeHosp($hosp);
	      $em->flush($patient);

	      $request->getSession()->getFlashBag()->add('info', "Le séjour d'hospitalisation concerné a bien été supprimée.");

	      return $this->render('BimoBundle:Patient:viewPatient.html.twig', array(
	      'patient' => $patient,
	    ));
	    }
	    
	    return $this->render('BimoBundle:Hosp:deleteHosp.html.twig', array(
	      'patient' => $patient,
	      'hosp'    => $hosp,
	      'form'   => $form->createView(),
	    ));
    } 
    public function viewHospAction($id)
    {
	    $em = $this->getDoctrine()
	      ->getManager()
	    ;
	    $hosp = $em
	    	->getRepository('BimoBundle:Hosp')
	    	->find($id);

	    if (null === $hosp) {
	      throw new NotFoundHttpException("L'hospitalisation d'id ".$id." n'existe pas.");
    	}
	    $listBimo = $em
	    	->getRepository('BimoBundle:Bimo')
	    	->getBimoFromHosp($hosp)
	    ;

	    // Le render ne change pas, on passait avant un tableau, maintenant un objet
	    return $this->render('BimoBundle:Hosp:viewHosp.html.twig', array(
	      'hosp' => $hosp,
	      'listBimo' => $listBimo,
	    ));
    }

    public function EditHospAction($id, Request $request)
    {
    	$em = $this
	    	->getDoctrine()
	      	->getManager()
	    ;
 		$hosp = $em
	      	->getRepository('BimoBundle:Hosp')
	      	->find($id)
	    ;
	    $form = $this
	    	->get('form.factory')
	    	->create(HospType::class, $hosp);


	    if ($request->isMethod('POST') &&
	    	$form->handleRequest($request)->isValid()) 
	    {
			$em = $this->getDoctrine()->getManager();
			$em->persist($hosp);
			$em->flush();

			$listBimo = $em
	    	->getRepository('BimoBundle:Bimo')
	    	->getBimoFromHosp($hosp)
	    	;

			return $this->render('BimoBundle:Hosp:viewHosp.html.twig', array(
	      		'hosp' => $hosp,
	      		'listBimo' => $listBimo,
	  		));
	    }

	    return $this->render('BimoBundle:hosp:editHosp.html.twig', array(
	      'form' => $form->createView(),
	      'hosp' => $hosp,
	    ));

    }

}