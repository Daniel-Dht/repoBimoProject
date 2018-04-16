<?php
namespace UserBundle\Controller;

use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        // Create a new blank user and process the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $usernameForm = $form->get('username')->getdata();
            $checkUsername = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('UserBundle:User')
                ->getUserByUsername($usernameForm)
            ;
            if($checkUsername != null){
                return $this->render('register.html.twig', [
                    'form' => $form->createView(),
                    'usernameAlreadyTaken' => $checkUsername,
                ]);
            }

            // Set their role
            $user->setRoles(array('ROLE_SUPER_ADMIN'));
            $user->setSalt('ok');

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}