<?php

namespace App\Controller;

use App\Entity\Site;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends Controller
{
    /**
     * @Route(
     * "/admin/site",
     * name="gestion_site",
     * methods={"GET"}
     * )
     */
    public function adminSite( PaginatorInterface $paginator, Request $request )
    {
        $allSites = $this -> getRepo() -> findAllSites();
        return $this->render('admin/admin_site.html.twig', [
            'allSites' => $this -> getPaginatedList( $allSites, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/site/ajouter/{nomSite}",
     * name="site_add",
     * methods={"GET"}
     * )
     */
    public function addSite( $nomSite = '', PaginatorInterface $paginator, Request $request )
    {
        $newSite = new Site();
        $newSite -> setNomSite( $nomSite );
        $this -> getEm() -> persist( $newSite );
        $this -> getEm() -> flush();

        $allSites = $this -> getRepo() -> findAllSites();

        return $this->render('admin/admin_site_table.html.twig', [
            'allSites' => $this -> getPaginatedList( $allSites, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/site/supprimer/{id}",
     * name="site_remove",
     * methods={"GET"}
     * )
     */
    public function removeSite( $id = '', PaginatorInterface $paginator, Request $request )
    {
        $siteToRemove = $this -> getRepo() -> find( $id );
        $this -> getEm() -> remove( $siteToRemove );
        $this -> getEm() -> flush();

        $allSites = $this -> getRepo() -> findAllSites();

        return $this->render('admin/admin_site_table.html.twig', [
            'allSites' => $this -> getPaginatedList( $allSites, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/site/editer/{id}/nom/{nomSite}",
     * name="site_edit",
     * methods={"GET"}
     * )
     */
    public function editSite( $id = '', $nomSite = '', PaginatorInterface $paginator, Request $request )
    {
        $siteToEdit = $this -> getRepo() -> find( $id );
        $siteToEdit -> setNomSite( $nomSite );
        $this -> getEm() -> persist( $siteToEdit );
        $this -> getEm() -> flush();

        $allSites = $this -> getRepo() -> findAllSites();

        return $this->render('admin/admin_site_table.html.twig', [
            'allSites' => $this -> getPaginatedList( $allSites, $paginator, $request )
        ]);
    }

    /**
     * @Route(
     * "/admin/site/search/nom/{nomSite}",
     * name="site_search",
     * methods={"GET"}
     * )
     */
    public function searchSite( $nomSite = '', PaginatorInterface $paginator, Request $request )
    {
        $foundSites = $this -> getRepo() -> getBySiteName( $nomSite, 0, 5 );

        if( $nomSite === 'empty' )
        {
            $foundSites = $this -> getRepo() -> findAllSites();
        }

        return $this->render('admin/admin_site_table.html.twig', [
            'allSites' => $this -> getPaginatedList( $foundSites, $paginator, $request )
        ]);
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
            5
        );

        $paginatedObjects -> setTemplate( 'pagination/twitter_bootstrap_v4_pagination.html.twig' );
        $paginatedObjects -> setUsedRoute( 'gestion_site' );

        return $paginatedObjects;
    }

    public function getEm() {
        return $this -> getDoctrine() -> getManager();
    }

    public function getRepo()
    {
        return $this -> getDoctrine() -> getRepository( Site::class );
    }
}
