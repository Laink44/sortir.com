<?php

namespace App\Controller\Web;

use App\Entity\Ville;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends Controller
{
    /**
     * @Route(
     * "/admin/ville",
     * name="gestion_ville",
     * methods={"GET"}
     * )
     */
    public function adminVille( PaginatorInterface $paginator, Request $request )
    {
        $allVilles = $this -> getRepo() -> findAllVilles();
        return $this->render('admin/admin_ville.html.twig', [
            'allVilles' => $this -> getPaginatedList( $allVilles, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/ville/ajouter/ville/{nomVille}/cp/{codePostal}",
     * name="ville_add",
     * methods={"GET"}
     * )
     */
    public function addVille( $nomVille = '', $codePostal = '', PaginatorInterface $paginator, Request $request )
    {
        $newVille = new Ville();
        $newVille -> setNomVille( $nomVille );
        $newVille -> setCodePostal( $codePostal );
        $this -> getEm() -> persist( $newVille );
        $this -> getEm() -> flush();

        $allVilles = $this -> getRepo() -> findAllVilles();

        return $this->render('admin/admin_ville_table.html.twig', [
            'allVilles' => $this -> getPaginatedList( $allVilles, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/ville/supprimer/{id}",
     * name="ville_remove",
     * methods={"GET"}
     * )
     */
    public function removeVille( $id = '', PaginatorInterface $paginator, Request $request )
    {
        $villeToRemove = $this -> getRepo() -> find( $id );
        $this -> getEm() -> remove( $villeToRemove );
        $this -> getEm() -> flush();

        $allVilles = $this -> getRepo() -> findAllVilles();

        return $this->render('admin/admin_ville_table.html.twig', [
            'allVilles' => $this -> getPaginatedList( $allVilles, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/ville/editer/{id}/nom/{nomVille}/code-postal/{codePostal}",
     * name="ville_edit",
     * methods={"GET"}
     * )
     */
    public function editVille( $id = '', $nomVille = '', $codePostal = '', PaginatorInterface $paginator, Request $request )
    {
        $villeToEdit = $this -> getRepo() -> find( $id );
        $villeToEdit -> setNomVille( $nomVille );
        $villeToEdit -> setCodePostal( $codePostal );
        $this -> getEm() -> persist( $villeToEdit );
        $this -> getEm() -> flush();

        $allVilles = $this -> getRepo() -> findAllVilles();

        return $this->render('admin/admin_ville_table.html.twig', [
            'allVilles' => $this -> getPaginatedList( $allVilles, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/ville/search/nom/{nomVille}",
     * name="ville_search",
     * methods={"GET"}
     * )
     */
    public function searchVille( $nomVille = '', PaginatorInterface $paginator, Request $request )
    {
        $foundCities = $this -> getRepo() -> getByVilleName( $nomVille, 0, 15 );

        if( $nomVille === 'empty' )
        {
            $foundCities = $this -> getRepo() -> findAllVilles();
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
    public function searchVilleAsJson( $nomVille = '' )
    {
        $foundCities = $this -> getRepo() -> getByVilleNameStartingWith( $nomVille, 0, 5 );

        if( $nomVille === 'empty' )
        {
            $foundCities = $this -> getRepo() -> findAllVilles();
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

    public function getAllVilles()
    {
        return $this -> getRepo() -> findAll();
    }

    public function getPaginatedList( Array $listOfObjectsToPaginate, PaginatorInterface $paginator, Request $request )
    {
        $paginatedObjects = $paginator -> paginate(
            $listOfObjectsToPaginate,
            $request -> query -> getInt( 'page', 1 ),
            15
        );

        $paginatedObjects -> setTemplate( 'pagination/twitter_bootstrap_v4_pagination.html.twig' );
        $paginatedObjects -> setUsedRoute( 'gestion_ville' );

        return $paginatedObjects;
    }

    public function getEm() {
        return $this -> getDoctrine() -> getManager();
    }

    public function getRepo()
    {
        return $this -> getDoctrine() -> getRepository( Ville::class );
    }
}
