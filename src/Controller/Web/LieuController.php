<?php

namespace App\Controller\Web;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Repository\VillesRepository;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends Controller
{
    /**
     * @Route(
     * "/admin/lieu",
     * name="gestion_lieu",
     * methods={"GET"}
     * )
     */
    public function adminLieu( PaginatorInterface $paginator, Request $request, VillesRepository $villeRep )
    {
        $allLieux = $this -> getRepo() -> findAllLieux();

        return $this->render('admin/admin_lieu.html.twig', [
            'allLieux' => $this -> getPaginatedList( $allLieux, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/lieu/ajouter/{nomLieu}/{rue}/{latitude}/{longitude}/{villeId}",
     * name="lieu_add",
     * methods={"GET"}
     * )
     */
    public function addLieu(
        $nomLieu = '',
        $rue = '',
        $latitude = 0.0,
        $longitude = 0.0,
        $villeId = '',
        PaginatorInterface $paginator,
        Request $request,
        VillesRepository $villeRepo
    ) {
        $ville = $villeRepo -> find( $villeId );

        $newLieu = new Lieu();
        $newLieu -> setNomLieu( $nomLieu );
        $newLieu -> setRue( $rue );
        $newLieu -> setLatitude( $latitude );
        $newLieu -> setLongitude( $longitude );
        $newLieu -> setVille( $ville );

        $this -> getEm() -> persist( $newLieu );
        $this -> getEm() -> flush();

        $allLieux = $this -> getRepo() -> findAllLieux();

        return $this->render('admin/admin_lieu_table.html.twig', [
            'allLieux' => $this -> getPaginatedList( $allLieux, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/lieu/supprimer/{id}",
     * name="lieu_remove",
     * methods={"GET"}
     * )
     */
    public function removeLieu( $id = '', PaginatorInterface $paginator, Request $request )
    {
        $lieuToRemove = $this -> getRepo() -> find( $id );
        $this -> getEm() -> remove( $lieuToRemove );
        $this -> getEm() -> flush();

        $allLieux = $this -> getRepo() -> findAllLieux();

        return $this->render('admin/admin_lieu_table.html.twig', [
            'allLieux' => $this -> getPaginatedList( $allLieux, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/lieu/editer/{id}/{nomLieu}/{rue}/{latitude}/{longitude}",
     * name="lieu_edit",
     * methods={"GET"}
     * )
     */
    public function editLieu(
        $id = '',
        $nomLieu = '',
        $rue = '',
        $latitude = 0.0,
        $longitude = 0.0,
        PaginatorInterface $paginator,
        Request $request
    ) {
        $lieuToEdit = $this -> getRepo() -> find( $id );
        $lieuToEdit -> setNomLieu( $nomLieu );
        $lieuToEdit -> setRue( $rue );
        $lieuToEdit -> setLatitude( $latitude );
        $lieuToEdit  -> setLongitude( floatval($longitude) );
        $this -> getEm() -> persist( $lieuToEdit );
        $this -> getEm() -> flush();

        $allSites = $this -> getRepo() -> findAllLieux();

        return $this->render('admin/admin_lieu_table.html.twig', [
            'allLieux' => $this -> getPaginatedList( $allSites, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/lieu/search/nom/{nomLieu}",
     * name="lieu_search",
     * methods={"GET"}
     * )
     */
    public function searchLieu( $nomLieu = '', PaginatorInterface $paginator, Request $request )
    {
        $foundLocations = $this -> getRepo() -> getByLocationName( $nomLieu, 0, 5 );

        if( $nomLieu === 'empty' )
        {
            $foundLocations = $this -> getRepo() -> findAllLieux();
        }

        return $this->render('admin/admin_lieu_table.html.twig', [
            'allLieux' => $this -> getPaginatedList( $foundLocations, $paginator, $request )
        ]);
    }

    public function getAllLieux()
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
        $paginatedObjects -> setUsedRoute( 'gestion_lieu' );

        return $paginatedObjects;
    }

    public function getEm() {
        return $this -> getDoctrine() -> getManager();
    }

    public function getRepo()
    {
        return $this -> getDoctrine() -> getRepository( Lieu::class );
    }
}
