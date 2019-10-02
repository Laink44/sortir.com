<?php

namespace App\Controller;

use App\Entity\Site;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function adminSite()
    {
        return $this->render('admin/admin_site.html.twig', [
            'allSites' => $this -> getAllSites()
        ]);
    }

    /**
     * @Route(
     * "/admin/site/ajouter/{nomSite}",
     * name="site_add",
     * methods={"GET"}
     * )
     */
    public function addSite( $nomSite = '' )
    {
        $newSite = new Site();
        $newSite -> setNomSite( $nomSite );
        $this -> getEm() -> persist( $newSite );
        $this -> getEm() -> flush();

        return $this->render('admin/admin_site_table.html.twig', [
            'allSites' => $this -> getAllSites()
        ]);
    }

    /**
     * @Route(
     * "/admin/site/supprimer/{id}",
     * name="site_remove",
     * methods={"GET"}
     * )
     */
    public function removeSite( $id = '' )
    {
        $siteToRemove = $this -> getRepo() -> find( $id );
        $this -> getEm() -> remove( $siteToRemove );
        $this -> getEm() -> flush();

        return $this->render('admin/admin_site_table.html.twig', [
            'allSites' => $this -> getAllSites()
        ]);
    }

    /**
     * @Route(
     * "/admin/site/editer/{id}/nom/{nomSite}",
     * name="site_edit",
     * methods={"GET"}
     * )
     */
    public function editSite( $id = '', $nomSite = '' )
    {
        $siteToEdit = $this -> getRepo() -> find( $id );
        $siteToEdit -> setNomSite( $nomSite );
        $this -> getEm() -> persist( $siteToEdit );
        $this -> getEm() -> flush();

        return $this->render('admin/admin_site_table.html.twig', [
            'allSites' => $this -> getAllSites()
        ]);
    }

    public function getAllSites()
    {
        $siteRepository = $this -> getDoctrine() -> getRepository( Site::class );
        return $this -> getRepo() -> findAll();
    }

    public function getEm() {
        return $this -> getDoctrine() -> getManager();
    }

    public function getRepo()
    {
        return $this -> getDoctrine() -> getRepository( Site::class );
    }
}
