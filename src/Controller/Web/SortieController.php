<?php

namespace App\Controller\Web;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\CreateSortieType;
use App\Repository\InscriptionRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SortieController extends Controller
{
    /**
     * @Route(
     * "/create_sortie",
     * name="index_sortie",
     * methods={"GET"}
     * )
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface $em,
                             Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $sortie = new Sortie();
        $sortieForm = $this->createForm(CreateSortieType::class, $sortie);

        $sortieForm->handleRequest($request);
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {



           // $em->flush();
            return $this->redirectToRoute("participant_login");
//            $token = new UsernamePasswordToken($user, null,
//                'main', $user->getRoles());
//            $this->container->get('security.token_storage')->setToken($token);
//            $this->container->get('session')->set('_security_main', serialize($token));
//            return $this->redirectToRoute('article_liste');
        }

        return $this->render('sortie/create.html.twig', ["form" => $sortieForm->createView()]);
    }


    /**
     * @Route(
     * "/create_sortie",
     * name="create_sortie",
     * methods={"POST"}
     * )
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function post(EntityManagerInterface $em,
                          Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
              $sortie = new Sortie();
        $sortieForm = $this->createForm(CreateSortieType::class, $sortie);
        $sortieForm->submit();
        $sortieForm->handleRequest($request);
        return $this->render('sortie/create.html.twig', [



        ]);
    }

    /**
     * @Route(
     * "/sorties",
     * name="sorties",
     * methods={"GET"}
     * )
     * @param PaginatorInterface $paginator
     * @param SortiesRepository $sortiesRepository
     * @param Request $request
     * @return Response
     */
    public function sorties(PaginatorInterface $paginator, SortiesRepository $sortiesRepository, Request $request){

        $allSorties = $sortiesRepository->findAll();

        return $this->render('sortie/index.html.twig', [
            'allSorties'
                => $this->getPaginatedList($allSorties, $paginator, $request ),
            ]);
    }

    public function getPaginatedList( Array $listOfObjectsToPaginate, PaginatorInterface $paginator, Request $request )
    {
        $paginatedObjects = $paginator -> paginate(
            $listOfObjectsToPaginate,
            $request -> query -> getInt( 'page', 1 ),
            10
        );

        $paginatedObjects -> setTemplate( 'pagination/twitter_bootstrap_v4_pagination.html.twig' );
        $paginatedObjects -> setUsedRoute( 'sorties' );

        return $paginatedObjects;
    }

    public function getEm() {
        return $this -> getDoctrine() -> getManager();
    }
    public function getRepo($class)
    {
        return $this -> getDoctrine() -> getRepository( $class );
    }
}
