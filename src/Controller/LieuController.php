<?php

namespace App\Controller;

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
     * "/admin/lieu/ajouter/{nomSite}",
     * name="lieu_add",
     * methods={"GET"}
     * )
     */
    public function addLieu( $nomLieu = '', PaginatorInterface $paginator, Request $request )
    {
//        $newSite = new Site();
//        $newSite -> setNomSite( $nomSite );
//        $this -> getEm() -> persist( $newSite );
//        $this -> getEm() -> flush();
//
//        $allSites = $this -> getRepo() -> findAllSites();
//
//        return $this->render('admin/admin_site_table.html.twig', [
//            'allSites' => $this -> getPaginatedList( $allSites, $paginator, $request )
//        ]);
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
//        $siteToRemove = $this -> getRepo() -> find( $id );
//        $this -> getEm() -> remove( $siteToRemove );
//        $this -> getEm() -> flush();
//
//        $allSites = $this -> getRepo() -> findAllSites();
//
//        return $this->render('admin/admin_site_table.html.twig', [
//            'allSites' => $this -> getPaginatedList( $allSites, $paginator, $request )
//        ]);
    }

    /**
     * @Route(
     * "/admin/lieu/editer/{id}/nom/{nomLieu}",
     * name="lieu_edit",
     * methods={"GET"}
     * )
     */
    public function editLieu( $id = '', $nomLieu = '', PaginatorInterface $paginator, Request $request )
    {
//        $siteToEdit = $this -> getRepo() -> find( $id );
//        $siteToEdit -> setNomSite( $nomSite );
//        $this -> getEm() -> persist( $siteToEdit );
//        $this -> getEm() -> flush();
//
//        $allSites = $this -> getRepo() -> findAllSites();
//
//        return $this->render('admin/admin_site_table.html.twig', [
//            'allSites' => $this -> getPaginatedList( $allSites, $paginator, $request )
//        ]);
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
//        $foundSites = $this -> getRepo() -> getBySiteName( $nomSite, 0, 5 );
//
//        if( $nomSite === 'empty' )
//        {
//            $foundSites = $this -> getRepo() -> findAllSites();
//        }
//
//        return $this->render('admin/admin_site_table.html.twig', [
//            'allSites' => $this -> getPaginatedList( $foundSites, $paginator, $request )
//        ]);
    }

    public function getAllSites()
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
