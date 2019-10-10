<?php

namespace App\Controller\Web;

use App\Entity\Ville;
use App\Repository\VillesRepository;
use App\Service\PaginatorService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends Controller
{

    //     * methods={"GET"}
    const ORIGIN_HOME       = 'home';
    const ORIGIN_PAGINATOR  = 'paginator';
    const ORIGIN_SEARCHBAR  = 'searchbar';
    const ORIGIN_REMOVE     = 'remove';
    const ORIGIN_ADD        = 'add';
    const ORIGIN_EDIT       = 'edit';
    /**
     * @Route(
     * "/admin/ville",
     * name="gestion_ville",
     * methods={"GET"}
     * )
     */
    public function adminVille(
        PaginatorInterface $paginator,
        Request $request,
        VillesRepository $cityRepo,
        PaginatorService $paginatorService
    )
    {
        $search         = $request -> query -> get( 'citysearch', '' );
        $origin         = $request -> query -> get( 'origin', self::ORIGIN_HOME );
        $currentPage    = $request -> query -> get( 'currentpage', 1 );
        $destination    = 'admin/admin_ville.html.twig';

        switch( $origin ) {
            case self::ORIGIN_HOME :
                $destination = 'admin/admin_ville.html.twig';
                break;
            case self::ORIGIN_PAGINATOR :
            case self::ORIGIN_SEARCHBAR :
            case self::ORIGIN_REMOVE :
            case self::ORIGIN_ADD :
            case self::ORIGIN_EDIT :
                $destination = 'admin/admin_ville_table.html.twig';
                break;
            default:
                $destination = 'home.html.twig';
                break;
        }

        // NOMBRE DE VILLES
        // Dénombre les villes de la table idoine, ce qui sera utile pour l'évaluation de la variable offset
        $rowCount = 0;
        if(
            ( $origin == self::ORIGIN_SEARCHBAR || $origin == self::ORIGIN_PAGINATOR )
            && $search
            && $search != ''
            && $search != 'empty'
        ) {
            $rowCount = $cityRepo -> getCityCountByName( $search );
        } else {
            $rowCount = $cityRepo -> getCityCount();
        }

        // PARAMETRES DE PAGINATION
        $maxByPage      = 15;
        $numberOfRange  = 5;
        $viewParams     = $paginatorService -> getViewParams( $currentPage, $maxByPage, $rowCount, $numberOfRange );
        $offset         = $paginatorService -> getOffset( $currentPage, $maxByPage );

        // LISTE DE VILLES
        $allVilles = [];
        if(
            ( $origin == self::ORIGIN_SEARCHBAR || $origin == self::ORIGIN_PAGINATOR )
            && $search
            && $search != ''
            && $search != 'empty'
        ) {
            $allVilles  = $cityRepo -> getByVilleName( $search, $offset, $maxByPage );
        } else {
            $allVilles  = $cityRepo -> findAllVilles( $offset, $maxByPage );
        }

        return $this->render( $destination, [
            'allVilles'     => $this -> getPaginatedList( $allVilles, $paginator, $request ),
            'viewParams'    => $viewParams
        ]);
    }

    /**
     * @Route(
     * "/admin/ville/ajouter",
     * name="ville_add",
     * methods={"GET"}
     * )
     */
    public function addVille( PaginatorInterface $paginator, Request $request )
    {
        $newVille = new Ville();
        $newVille -> setNomVille( $request -> query -> get( 'nom', '' ) );
        $newVille -> setCodePostal( $request -> query -> get( 'cp', '' )  );
        $this -> getEm() -> persist( $newVille );
        $this -> getEm() -> flush();

        return $this -> redirectToRoute( 'gestion_ville', $request -> query -> all() );
    }

    /**
     * @Route(
     * "/admin/ville/supprimer/{id}",
     * name="ville_remove",
     * methods={"GET"}
     * )
     */
    public function removeVille( $id = '', PaginatorInterface $paginator, Request $request, VillesRepository $cityRepo )
    {
        $villeToRemove = $cityRepo -> find( $id );
        $this -> getEm() -> remove( $villeToRemove );
        $this -> getEm() -> flush();

        return $this -> redirectToRoute( 'gestion_ville', $request -> query -> all() );
    }

    /**
     * @Route(
     * "/admin/ville/editer",
     * name="ville_edit",
     * methods={"GET"}
     * )
     */
    public function editVille( PaginatorInterface $paginator, Request $request, VillesRepository $cityRepo )
    {
        $villeToEdit = $cityRepo -> find( $request -> query -> get( 'id', '' ) );
        $villeToEdit -> setNomVille( $request -> query -> get( 'nom', '' ) );
        $villeToEdit -> setCodePostal( $request -> query -> get( 'cp', '' ) );
        $this -> getEm() -> persist( $villeToEdit );
        $this -> getEm() -> flush();

        return $this -> redirectToRoute( 'gestion_ville', $request -> query -> all() );
    }

    /**
     * @Route(
     * "/admin/ville/search/nom/{nomVille}",
     * name="ville_search",
     * methods={"GET"}
     * )
     */
    public function searchVille( $nomVille = '', PaginatorInterface $paginator, Request $request, VillesRepository $cityRepo )
    {
        $foundCities = $cityRepo -> getByVilleName( $nomVille, 0, 15 );

        if( $nomVille === 'empty' )
        {
            $foundCities = $cityRepo -> findAllVilles();
        }

        return $this->render('admin/admin_ville_table.html.twig', [
            'allVilles' => $this -> getPaginatedList( $foundCities, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/ville/search/json/nom/{nomVille}",
     * name="ville_search_json",
     * methods={"GET"}
     * )
     */
    public function searchVilleAsJson( $nomVille = '', VillesRepository $cityRepo )
    {
        $foundCities = $cityRepo -> getByVilleNameStartingWith( $nomVille, 0, 5 );

        if( $nomVille === 'empty' )
        {
            $foundCities = $cityRepo -> findAllVilles();
        }

        $cities = [];

        foreach( $foundCities as $city ) {
            $cityToShow = array(
                "value" => $city -> getId(),
                "label" => $city -> getNomVille()
            );

            array_push( $cities, $cityToShow );
        }

        $json_response = json_encode( $cities );

        $response = new Response();
        $response -> setContent( $json_response );

        $response -> headers -> set('Content-Type', 'application/json');

        return $response;
    }

    public function getAllVilles( VillesRepository $cityRepo )
    {
        return $cityRepo -> findAll();
    }

    public function getPaginatedList( Array $listOfObjectsToPaginate, PaginatorInterface $paginator, Request $request )
    {
        $paginatedObjects = $paginator -> paginate( $listOfObjectsToPaginate
        );

        $paginatedObjects -> setTemplate( 'pagination/pagination.html.twig' );
        $paginatedObjects -> setUsedRoute( 'gestion_ville' );

        return $paginatedObjects;
    }

    public function getEm() {
        return $this -> getDoctrine() -> getManager();
    }
//
//    public function getRepo()
//    {
//        return $this -> getDoctrine() -> getRepository( Ville::class );
//    }
}
