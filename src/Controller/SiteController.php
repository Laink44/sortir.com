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
        $siteRepository = $this -> getDoctrine() -> getRepository( Site::class );
        $allSites = $siteRepository ->findAll();

        return $this->render('admin/admin_site.html.twig', [
            'allSites' => $allSites
        ]);
    }
}
