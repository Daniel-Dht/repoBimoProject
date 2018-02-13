<?php
// src/OC/UserBundle/Controller/SecurityController.php;

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; 

use UserBundle\Form\UserType ;
use UserBundle\Form\UserEditType ;

use UserBundle\Entity\User;


class SecurityController extends Controller
{
  public function loginAction(Request $request)
  {
    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
    if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      return $this-->redirectToRoute('view');
    }

    // Le service authentication_utils permet de récupérer le nom d'utilisateur
    // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
    // (mauvais mot de passe par exemple)
    $authenticationUtils = $this->get('security.authentication_utils');

    return $this->render('login.html.twig', array(
      'last_username' => $authenticationUtils->getLastUsername(),
      'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));

    $user = $this->getUser();
    $user->getUsername();


    return $this->redirectToRoute('login_check');
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

        // , array('id' => $user->getId()));
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

      //On génère les bimos associée:
      // $listBimo =$em2 = $this->getDoctrine()
      //   ->getManager()
      //   ->getRepository('BimoBundle:Bimo')
      //   ->findBy(array('user' => $user))
      // ;

      // Le render ne change pas, on passait avant un tableau, maintenant un objet
      return $this->render('UserBundle:User:viewUser.html.twig', array(
        'user' => $user,
        // 'listBimo' => $listBimo,
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

        // , array('id' => $user->getId()));
      }

      return $this->render('UserBundle:user:editUser.html.twig', array(
        'form' => $form->createView(),
        'user' => $user,
      ));

    }
}
