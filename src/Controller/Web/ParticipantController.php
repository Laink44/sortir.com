<?php

namespace App\Controller\Web;

use App\Entity\Participant;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;

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
        $actualUser = $this -> getUser();

        if( !$actualUser ){ // Pour le cas ou il serait impossible de récupérer l'utilisateur
            throw $this -> createNotFoundException( "L'utilisateur n'a pas pu être récupéré" );
        }

        $isDirty    = false;

        // AVATAR
        $images     = $request -> files;

        if( $images ) {
            foreach ( $images as $img ) {
                if( $img ) {
                    switch( $img -> guessExtension() ) {
                        case 'jpg'  :
                        case 'png'  :
                        case 'jpeg' :
                            $fileName = uniqid() . $img -> getClientOriginalName();
                            try {
                                $img -> move(
                                    $this->getParameter('avatar_directory'),
                                    $fileName
                                );
                                $actualUser -> setAvatar( $fileName );
                                $isDirty = true;
                            } catch ( FileException $e ) {
                                throw $this -> createNotFoundException( "Problème lors de l'ajout de l'image" );
                            }
                            break;
                        default:
                            throw $this -> createNotFoundException( "Extension non acceptée" );
                    }
                }
            }
        }

        // PSEUDO
        $pseudo = $request -> request -> get( 'inputPseudo' );
        if( $pseudo && $pseudo != $actualUser -> getUserName() ) {
            $actualUser -> setUserName( $pseudo );
            $isDirty = true;
        }
        // PRENOM
        $prenom = $request -> request -> get( 'inputPrenom' );
        if( $prenom && $prenom != $actualUser -> getPrenom() ) {
            $actualUser -> setPrenom( $prenom );
            $isDirty = true;
        }
        // NOM
        $nom = $request -> request -> get( 'inputNom' );
        if( $nom && $nom != $actualUser -> getNom() ) {
            $actualUser -> setNom( $nom );
            $isDirty = true;
        }
        // TELEPHONE
        $telephone = $request -> request -> get( 'inputTelephone' );
        if( $telephone && $telephone != $actualUser -> getTelephone() ) {
            $actualUser -> setTelephone( $telephone );
            $isDirty = true;
        }
        // EMAIL
        $mail = $request -> request -> get( 'inputEmail' );
        if( $mail && $mail != $actualUser -> getMail() ) {
            $actualUser -> setMail( $mail );
            $isDirty = true;
        }
        // PASSWORD
        $password = $request -> request -> get( 'inputMotDePasse' );
        $confirmation = $request -> request -> get( 'inputConfirmation' );
        if( $password && $password != '' && $password === $confirmation ) {
            $hash = $encoder->encodePassword( $password );
            $actualUser -> setPassword( $hash );
            $isDirty = true;
        }

        if( $isDirty ) {
            $em -> persist( $actualUser );
            $em -> flush();
        }

        return $this->render('participant/profil_details.html.twig', [
            'actualUser' => $actualUser
        ]);
    }
}