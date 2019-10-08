<?php

namespace App\Controller\Web;

use App\Entity\Participant;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Ramsey\Uuid\Uuid;

class ParticipantController extends Controller
{

    /**
     * @Route("/register", name="participant_register")
     * @param EntityManagerInterface $em
     * @param Request $request
     *
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
            $user->setAdministrateur(false);
            $user->setActif(true);
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("participant_login");
        }

        return $this->render('participant/register.html.twig', [
            'registerForm' => $registerForm->createView()
        ]);
    }


    /**
     * @Route("/login", name="participant_login",methods={"GET", "POST"})
     *
     * e
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render("participant/login.html.twig", [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/logout", name="participant_logout")
     */
    public function logout() {
        // rien à faire
    }

    /**
     * @Route(
     * "/profil/editer",
     * name="profil_edit",
     * methods={"GET"}
     * )
     */
    public function editProfil( Request $request ) {
        $actualUser = $this -> getUser();

        return $this->render('participant/profil_edit.html.twig', [
            'actualUser' => $actualUser
        ]);
    }

    /**
     * @Route(
     * "/profil/consulter",
     * name="profil_show",
     * methods={"GET"}
     * )
     */
    public function showProfil( Request $request ) {
        $actualUser = $this -> getUser();

        return $this->render('participant/profil_details.html.twig', [
            'actualUser' => $actualUser
        ]);
    }

    /**
     * @Route(
     * "/profil/sauver",
     * name="profil_save",
     * methods={"POST"}
     * )
     */
    public function saveProfil(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder
    ) {
        $images = $request -> files;
        $fileName = '';
        if( $images ) {
            foreach ( $images as $img ) {
                if( $img ) {
                    $fileName = uniqid().$img->getClientOriginalName();
                    try {
                        $img -> move(
                            $this->getParameter('avatar_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        dump( $e );
                    }
                }
            }
        }

        $actualUser = $this -> getUser();
        $actualUser -> setUserName( $request -> request -> get( 'inputPseudo' ) );
        $actualUser -> setPrenom( $request -> request -> get( 'inputPrenom' ) );
        $actualUser -> setNom( $request -> request -> get( 'inputPseudo' ) );
        $actualUser -> setTelephone( $request -> request -> get( 'inputTelephone' ) );
        $actualUser -> setMail( $request -> request -> get( 'inputEmail' ) );
        $hash = $encoder->encodePassword( $actualUser, $request -> request -> get( 'inputMotDePasse' ) );
        $actualUser -> setPassword( $hash );
        $actualUser -> setAvatar( $fileName );

        $em -> persist( $actualUser );
        $em -> flush();

        return $this->render('participant/profil_edit.html.twig', [
            'actualUser' => $actualUser
        ]);
    }
}