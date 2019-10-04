<?php

namespace App\Controller\Api;
use App\Entity\Lieu;

use App\Repository\LieuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
class LieuApiController extends Controller
{
    /**
     *
     * @Route("/lieu", name="lieu",methods={"GET"})
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @param LieuxRepository $lieuxRepository
     * @return Response
     */
    public function index(EntityManagerInterface $em,SerializerInterface $serializer, LieuxRepository $lieuxRepository)
    {

        $lieux = $lieuxRepository->findLieuByVilleId();

        $lieux_encode =  json_encode($lieux);


        $response = new Response($serializer->serialize($lieux,'json',[
            'groups'=>'groupe1'
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


       /* return $this->render('lieu/index.html.twig', [
            'controller_name' => 'LieuController',
            'lieux'=>$lieu,
        ]); */
    }



}
