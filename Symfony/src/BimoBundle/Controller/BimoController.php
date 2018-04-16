<?php

namespace BimoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use BimoBundle\Entity\MedProto;
use BimoBundle\Entity\Patient;
use BimoBundle\Entity\Bimo;

use BimoBundle\Form\MedProtoType ;
use BimoBundle\Form\BimoType ;
use BimoBundle\Form\BimoEditType ;
use BimoBundle\Form\BimoPatientType ;

use UserBundle\Entity\UserBimo;
use UserBundle\Entity\User;

class BimoController extends Controller
{


    public function AddMedProtoAction(Request $request, $idBimo)
    {

    	$medProto = new MedProto();

	    $bimo = $this
	    	->getDoctrine()
	      	->getManager()
	      	->getRepository('BimoBundle:Bimo')
	      	->find($idBimo)
	    ;

	    if (null === $bimo) {
	      throw new NotFoundHttpException("Le BIMO d'id ".$idBimo." n'existe pas.");
	    }

	    $form = $this
	    	->get('form.factory')
	    	->create(MedProtoType::class, $medProto);

	    if ($request->isMethod('POST') &&
	    	$form->handleRequest($request)->isValid()) 
	    {
	    	$emDos = $this->getDoctrine()
				->getManager()
				->getRepository('BimoBundle:MedProto');

	    	$texteDosage = $form->get('dosage')->getdata();
			$texteDosage = $emDos->dosageExpression($texteDosage);
	    	$medProto->setDosage($texteDosage);

	    	$texteDosageBefore = $form->get('dosageBefore')->getdata();
			$texteDosageBefore = $emDos->dosageExpression($texteDosageBefore);
	    	$medProto->setDosageBefore($texteDosageBefore);

	    	$bimo->addMedProto($medProto);
	    	$bimo->updateDate();

			$em = $this->getDoctrine()->getManager();
			
			$em->persist($medProto);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

			return $this->redirectToRoute('viewBimo', array(
				'id' => $bimo->getId(),
			));
	    }

	    $em = $this->getDoctrine() // On va chercher la liste des medoc !
            ->getManager()
            ->getRepository('BimoBundle:Medicaments')
        ;

        $listMedocs = $em->findAll() ;

	    return $this->render('addMedProto.html.twig', array(
	      'form' => $form->createView(),
	      'bimo' => $bimo,
	      'listMedocs' => $listMedocs,

	    ));

    }

	public function EditMedProtoAction(Request $request, $id)
    {

	    $medProto = $this
	    	->getDoctrine()
	      	->getManager()
	      	->getRepository('BimoBundle:MedProto')
	      	->find($id)
	    ;

	    if (null === $medProto) {
	      throw new NotFoundHttpException("La ligne de ce BIMO d'id ".$id." n'existe pas.");
	    }
	    $bimo = $medProto->getBimo();
	    if (null === $bimo) {
	      throw new NotFoundHttpException("Le BIMO d'id ".$medProto->getId()." n'existe pas.");
	    }
	    
	    $form = $this
	    	->get('form.factory')
	    	->create(MedProtoType::class, $medProto);

	    if ($request->isMethod('POST') &&
	    	$form->handleRequest($request)->isValid()) 
	    {
	    	$emDos = $this->getDoctrine()
				->getManager()
				->getRepository('BimoBundle:MedProto');

	    	$texteDosage = $form->get('dosage')->getdata();
			$texteDosage = $emDos->dosageExpression($texteDosage);
	    	$medProto->setDosage($texteDosage);


	    	$texteDosageBefore = $form->get('dosageBefore')->getdata();
			$texteDosageBefore = $emDos->dosageExpression($texteDosageBefore);
	    	$medProto->setDosageBefore($texteDosageBefore);

	    	$bimo->updateDate();
			$em = $this->getDoctrine()->getManager();
			$em->persist($medProto);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

			return $this->redirectToRoute('viewBimo', array(
				'id' => $bimo->getId(),
			));
	    }

	    $em = $this->getDoctrine() // On va chercher la liste des medoc !
            ->getManager()
            ->getRepository('BimoBundle:Medicaments')
        ;

        $listMedocs = $em->findAll() ;

	    return $this->render('BimoBundle:bimo:editMedProto.html.twig', array(
	      'form' => $form->createView(),
	      'bimo' => $bimo,
	      'listMedocs' => $listMedocs,
	      'medProto' => $medProto,

	    ));

    }


	// public function AddBimoAction(Request $request, $idPatient)
 //    {
 //    	$bimo = new Bimo();
 //    	//Si l'argument idPatient est non nul, on set l'attribut 'patient' du bimo avec le patient associé
 //    	if(isset($idPatient)){
 //    		$patient = $this
	// 	    	->getDoctrine()
	// 	      	->getManager()
	// 	      	->getRepository('BimoBundle:Patient')
	// 	      	->find($idPatient)
	//     	;
	//     	if (null == $patient) {
	//       		throw new NotFoundHttpException("Le patient d'id ".$id." n'existe pas.");
	//     	}
	//     	$bimo->setPatient($patient);
 //    	}
	//     if (empty($patient)) {
	// 	    $form = $this
	// 	    	->get('form.factory')
	// 	    	->create(BimoType::class, $bimo);
	//     }
	//     else{
	//     	$form = $this
	// 	    	->get('form.factory')
	// 	    	->create(BimoPatientType::class, $bimo);
	//     }
	//     // même méthode post pour les deux configurations :
	//     if ($request->isMethod('POST') &&
	//     	$form->handleRequest($request)->isValid()) 
	//     {

	// 		$em = $this->getDoctrine()->getManager();
	// 		$em->persist($bimo);
	// 		$em->flush();

	// 		$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

	// 		return $this->redirectToRoute('viewBimo', array(
	// 			'id' => $bimo->getId(),
	// 		));
	//     }
	//     $em = $this->getDoctrine() // On va chercher la liste des medoc !
 //            ->getManager()
 //            ->getRepository('BimoBundle:Medicaments')
 //        ;
 //        $listMedocs = $em->findAll() ;
	//     //Renvoie le formulaire d'un bimo permettant de choisir le patient associé
	//     if (empty($patient)) {


	//     	return $this->render('BimoBundle:Bimo:addBimo.html.twig', array(
	// 	      'form' => $form->createView(),
	//      	  'listMedocs' => $listMedocs,
	//     	));
	//     }


	//     //Renvoie le formulaire d'un bimo accocié à $patient
	//     return $this->render('BimoBundle:Bimo:addBimo.html.twig', array(
	//       'form' => $form->createView(),
	//       'patient' => $patient,
	//       'listMedocs' => $listMedocs,
	//     ));

 //    }
    public function AddBimoAction(Request $request, $idPatient)
    {
    	$bimo = new Bimo();

    	$patient = $this
		    	->getDoctrine()
		      	->getManager()
		      	->getRepository('BimoBundle:Patient')
		      	->find($idPatient)
	    	;
    	if (null == $patient) {
      		throw new NotFoundHttpException("Le patient d'id ".$id." n'existe pas.");
    	}

    	$bimo->setPatient($patient);
    	$bimo->setUrgency(0);

		$em = $this->getDoctrine()->getManager();
		$em->persist($bimo);
		$em->flush();

	    return $this->redirectToRoute('viewBimo', array(
				'id' => $bimo->getId(),
			));

    }

	public function editBimoAction($id, Request $request, $username)
    {
    	$em = $this
    		 ->getDoctrine()
	      	->getManager();
	    $bimo = $em 
	      	->getRepository('BimoBundle:Bimo')
	      	->find($id);

	    if (null === $bimo) {
	      throw new NotFoundHttpException("Le BIMO d'id ".$id." n'existe pas.");
	    }

	    $form = $this
	    	->get('form.factory')
	    	->create(BimoEditType::class, $bimo);
    	;

	    if ($request->isMethod('POST') &&
	    	$form->handleRequest($request)->isValid()) 
	    {

	    	// Gestion des update avec l'entité UserBimo
		    $user = $em 
		      	->getRepository('UserBundle:User')
		      	->getUserByUsername($username)
		    ;
		    if (null === $user) {
		      throw new NotFoundHttpException("Le username ".$username." n'existe pas.");
		    }

	    	$userBimo = new userBimo();
	    	$userBimo->setBimo($bimo);
	    	$userBimo->setUser($user);

			$em = $this->getDoctrine()->getManager();
			$em->persist($bimo);
			$em->persist($userBimo);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'BIMO bien enregistrée.');

			return $this->redirectToRoute('viewBimo', array('id' => $bimo->getId()));
	    }

	    $em = $this->getDoctrine() // On va chercher la liste des medoc !
            ->getManager()
            ->getRepository('BimoBundle:Medicaments')
        ;

        $listMedocs = $em->findAll() ;

	    return $this->render('BimoBundle:bimo:editBimo.html.twig', array(
	      'form' => $form->createView(),
	      'bimo' => $bimo,
	      'listMedocs' => $listMedocs,
	    ));

	}

	/**
	 * @ParamConverter("bimo", options={"mapping": {"bimo_id": "id"}})
	 */
	public function deleteBimoAction(Request $request, Bimo $bimo)
  	{
	    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
	    // Cela permet de protéger la suppression d'annonce contre cette faille
	    $form = $this->get('form.factory')->create();

	    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em->remove($bimo);
	      $em->flush();

	      $request->getSession()->getFlashBag()->add('info', "Le Bimo a bien été supprimée.");

	      return $this->redirectToRoute('listBimo');
	    }
	    
	    return $this->render('BimoBundle:Bimo:deleteBimo.html.twig', array(
	      'bimo' => $bimo,
	      'form'   => $form->createView(),
	    ));
    } 



    public function testAction()
    {
    	$user = $this->getUser();

		// Sinon, c'est une instance de notre entité User, on peut l'utiliser normalement
		$user->getUsername();

		return $this->render('test.html.twig');

    }

    public function viewBimoAction(Bimo $bimo)
    {

    	$listMedProto =$em = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('BimoBundle:MedProto')
	      ->findBy(array('bimo' => $bimo))
	    ;
	    return $this->render('BimoBundle:Bimo:viewBimo.html.twig', array(
	      'bimo' => $bimo,
	    ));
    }

    public function listAction($page)
	{
	    if ($page < 1) {
	      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
	    }

	    $em = $this->getDoctrine()
	    	->getManager()
	    	->getRepository('BimoBundle:Bimo')
	    ;

	    $nbPerPage = 15 ;
	    $listBimo = $em->getBimos($page, $nbPerPage);

	    // On calcule le nombre total de pages grâce au count($listBimo) qui retourne le nombre total d'annonces

    	$nbPages = ceil(count($listBimo) / $nbPerPage);

   		// Si la page n'existe pas, on retourne une 404
    	if ($page > $nbPages) {
      		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    	}

	    // Et modifiez le 2nd argument pour injecter notre liste
	    return $this->render('BimoBundle:Bimo:listBimo.html.twig', array(
	      'listBimo' => $listBimo,
	      'page' => $page,
	      'nbPages' => $nbPages
	    ));
	}
	public function urgentListAction($page)
	{
	    if ($page < 1) {
	      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
	    }

	    $em = $this->getDoctrine()
	    	->getManager()
	    	->getRepository('BimoBundle:Bimo')
	    ;

	    $nbPerPage = 15 ;
	    $listBimo = $em->getUrgentBimos($page, $nbPerPage);

	    // On calcule le nombre total de pages grâce au count($listBimo) qui retourne le nombre total d'annonces

    	$nbPages = ceil(count($listBimo) / $nbPerPage);

   		// Si la page n'existe pas, on retourne une 404
    	if ($page > $nbPages) {
      		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    	}

	    // Et modifiez le 2nd argument pour injecter notre liste
	    return $this->render('BimoBundle:Bimo:listBimo.html.twig', array(
	      'listBimo' => $listBimo,
	      'page' => $page,
	      'nbPages' => $nbPages
	    ));
	}

	/**
	 * @ParamConverter("bimo", options={"mapping": {"bimo_id": "id"}})
	 */
	public function PDFAction(Bimo $bimo)
    {
    	$listMedProto =$em = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('BimoBundle:MedProto')
	      ->findBy(array('bimo' => $bimo))
	    ;

	    // Appel du service génération pdf de snappyBundle
	    $snappy = $this->get('knp_snappy.pdf');

        //twig :
        $html = $this->renderView('BimoBundle:Bimo:BimoPDF.html.twig', array(
	      'bimo' => $bimo,
	      'listMedProto' => $listMedProto,
        ));
        $filename = 'PDFdinguerie';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

    public function deleteMedProtoAction(Request $request, $id)
  	{
	    $em = $this->getDoctrine()->getManager();

	    $medProto = $em
	    	->getRepository('BimoBundle:MedProto')
	    	->find($id);

	    if (null === $medProto) {
	      throw new NotFoundHttpException("La Ligne d'id ".$id." n'existe pas.");
	    }
	    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
	    // Cela permet de protéger la suppression d'annonce contre cette faille
	    $form = $this->get('form.factory')->create();

	    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	    	$bimo = $medProto->getBimo();
			$em->remove($medProto);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "Le medProto a bien été supprimée.");

			return $this->render('BimoBundle:Bimo:viewBimo.html.twig', array(
			   'bimo' => $bimo,
	    	));
	    }
	    
	    return $this->render('BimoBundle:Bimo:deleteMedProto.html.twig', array(
	      'medProto' => $medProto,
	      'bimo' => $medProto->getBimo(),
	      'form'   => $form->createView(),
	    ));
    }

}
