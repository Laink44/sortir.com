<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ParticipantController extends Controller
{
    /**
     * @Route("/participant", name="participant")
     */
    public function index()
    {
        return $this->render('participant/index.html.twig', [
            'controller_name' => 'ParticipantController',
        ]);
    }

    /**
     * @Route("/register", name="participant_register")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(EntityManagerInterface $em,
                             Request $request,
                             UserPasswordEncoderInterface $encoder)
    {
        $user = new Participant();
        $registerForm = $this->createForm(RegisterType::class, $user);

        $registerForm->handleRequest($request);
        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setMotDePasse($hash);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("participant_login");
//            $token = new UsernamePasswordToken($user, null,
//                'main', $user->getRoles());
//            $this->container->get('security.token_storage')->setToken($token);
//            $this->container->get('session')->set('_security_main', serialize($token));
//            return $this->redirectToRoute('article_liste');
        }

        return $this->render('participant/register.html.twig', [
            'registerForm' => $registerForm->createView()
        ]);
    }


    /**
     * @Route("/login", name="participant_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render("participant/login.html.twig", [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }


}
