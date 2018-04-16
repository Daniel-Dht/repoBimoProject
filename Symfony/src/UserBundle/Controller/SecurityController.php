<?php
// src/OC/UserBundle/Controller/SecurityController.php;

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter; 

use UserBundle\Form\UserType ;
use UserBundle\Form\UserEditType ;

use UserBundle\Entity\User;


class SecurityController extends Controller
{


    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
       $helper = $this->get('security.authentication_utils');

       return $this->render(
           'login.html.twig',
           array(
               'last_username' => $helper->getLastUsername(),
               'error'         => $helper->getLastAuthenticationError(),
           )
       );
    }



  public function indexAction(Request $request)
  {
    // replace this example code with whatever you need
    return $this->render('default/index.html.twig') ;
  }

  public function loginCheckAction(Request $request)
  {
    // replace this example code with whatever you need
    return $this->render('default/index.html.twig') ;
  }


/// ******************************************//
  public function listAction($page)
  {
      if ($page < 1) {
        throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
      }

      $em = $this->getDoctrine()
        ->getManager()
        ->getRepository('UserBundle:User')
      ;

      $nbPerPage = 12 ;
      $listUsers = $em->getUsers($page, $nbPerPage);

      // On calcule le nombre total de pages grâce au count($listUser) qui retourne le nombre total d'annonces

      $nbPages = ceil(count($listUsers) / $nbPerPage);

      // Si la page n'existe pas, on retourne une 404
      if ($page > $nbPages) {
          throw $this->createNotFoundException("La page ".$page." n'existe pas.");
      }

      // Et modifiez le 2nd argument pour injecter notre liste
      return $this->render('UserBundle:User:listUser.html.twig', array(
        'listUsers' => $listUsers,
        'page' => $page,
        'nbPages' => $nbPages
      ));
  }

  public function AddAction(Request $request)
    {

      $user = new User();
      $user->setSalt('');
      $user->setRoles(array('ROLE_USER'));

      $form = $this
        ->get('form.factory')
        ->create(UserType::class, $user);

      if ($request->isMethod('POST') &&
        $form->handleRequest($request)->isValid()) 
        {

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'user bien enregistrée.');

        return $this->render('UserBundle:User:viewUser.html.twig', array(
              'user' => $user,
          ));
      }

      return $this->render('UserBundle:User:addUser.html.twig', array(
        'form' => $form->createView(),
      ));
    }

  public function viewUserAction($id)
  {
    $em = $this->getDoctrine()
      ->getManager()
      ->getRepository('UserBundle:User')
    ;

    $user = $em->find($id);

    if (null === $user) {
      throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
    }

    // Le render ne change pas, on passait avant un tableau, maintenant un objet
    return $this->render('UserBundle:User:viewUser.html.twig', array(
      'user' => $user,
    ));
   }

    public function EditUserAction($id, Request $request)
    {
      
      $user = $this
        ->getDoctrine()
          ->getManager()
          ->getRepository('UserBundle:User')
          ->find($id)
      ;
      $form = $this
        ->get('form.factory')
        ->create(UserEditType::class, $user);

      if ($request->isMethod('POST') &&
        $form->handleRequest($request)->isValid()) 
      {

      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'profil bien modifié.');

      return $this->render('UserBundle:user:viewUser.html.twig', array(
            'user' => $user,
        ));
      }

      return $this->render('UserBundle:user:editUser.html.twig', array(
        'form' => $form->createView(),
        'user' => $user,
      ));

    }

  public function AddPatientToUserAction($idUser, $idPatient)
    {
      $em = $this->getDoctrine()->getManager();

      $user =$em
        ->getRepository('UserBundle:User')
        ->find($idUser)
      ;

      $patient = $em
        ->getRepository('BimoBundle:Patient')
        ->find($idPatient)
      ;

      $user->addPatient($patient);

      $em->persist($user);
      $em->flush();

      return $this->render('UserBundle:User:listPatientOfUser.html.twig', array(
        'user' => $user,
      ));
    }

  /**
   * @ParamConverter("user", options={"mapping": {"user_id": "id"}})
   * @ParamConverter("patient", options={"mapping": {"patient_id": "id"}})
   */
  public function removePatientFromUserAction(User $user,  \BimoBundle\Entity\Patient $patient)
  {
    $user->removePatient($patient);
    $em = $this->getDoctrine()->getManager();
    $em->persist($user);
    $em->flush();

    return $this->render('UserBundle:User:listPatientOfUser.html.twig', array(
      'user' => $user,
    ));
  }


  public function listPatientAtChargeAction()
  {
    return $this->render('UserBundle:User:listPatientOfUser.html.twig');
  }

  public function ownProfileAction($id)
  {
    $user =$em
        ->getRepository('UserBundle:User')
        ->getUser($id)
    ;
    return $this->render('UserBundle:User:viewUser.html.twig', array(
      'user' => $user,
    ));
  }

  public function deleteUserAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();

      $user = $em
        ->getRepository('UserBundle:User')
        ->find($id);

      if (null === $user) {
        throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
      }
      // On crée un formulaire vide, qui ne contiendra que le champ CSRF
      // Cela permet de protéger la suppression d'annonce contre cette faille
      $form = $this->get('form.factory')->create();

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em->remove($user);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', "L'utilisateur a bien été supprimée.");

        return $this->redirectToRoute('listUser');
      }
      
      return $this->render('UserBundle:user:deleteUser.html.twig', array(
        'user' => $user,
        'form'   => $form->createView(),
      ));
    }


}

