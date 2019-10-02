<?php

namespace App\Controller;

use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function adminVille()
    {
        $villeRepository = $this -> getDoctrine() -> getRepository( Ville::class );
        return $this->render('admin/admin_ville.html.twig', [
//            'controller_name' => 'ParticipantController',
        ]);
    }
}
