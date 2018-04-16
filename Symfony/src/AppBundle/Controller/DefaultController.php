<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use BimoBundle\Entity\MedProto;
use BimoBundle\Entity\Patient;
use BimoBundle\Entity\Bimo;

use BimoBundle\Form\PatientType ;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $snappy = $this->get('knp_snappy.pdf');

        // A partir d'une URL :
        // $filename = 'myFirstSnappyPDF';
        // $url = 'http://ourcodeworld.com';

        $id = 43;
       	$em = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('BimoBundle:Bimo')
	    ;
       	$bimo = $em->find($id);

	    if (null === $bimo) {
	      throw new NotFoundHttpException("La BIMO d'id ".$id." n'existe pas.");
    	}

    	$listMedProto =$em = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('BimoBundle:MedProto')
	      ->findBy(array('bimo' => $bimo))
	    ;

        //twig :
        $html = $this->renderView('BimoBundle:Bimo:viewBimo.html.twig', array(
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
    public function autoCAction(Request $request) {

        $em = $this->getDoctrine()
            ->getManager()
            ->getRepository('BimoBundle:Patient')
        ;

        $listPatient = $em->findAll() ;

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

        return $this->render('BimoBundle:Patient:TestAutoComp.html.twig', array(
          'listPatient' => $listPatient,
          'form' => $form->createView(),
        ));
      }

}