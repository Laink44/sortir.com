<?php

namespace App\Controller\Api;
use App\Entity\Lieu;

use App\Repository\LieuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/lieu")
 */
class LieuApiController extends Controller
{
    /**
     *
     * @Route("/", name="lieu",methods={"GET"})
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

    /**
     * @Route("/byVille/{id}", name="lieu_by_villeid")
     */
    public  function  villebyid($id='',EntityManagerInterface $em, LieuxRepository $lieuxRepository,SerializerInterface $serializer){
        $lieux = $lieuxRepository->findLieuByVilleId($id);
        $response = new Response($serializer->serialize($lieux,'json',[
            'groups'=>'groupe1'
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getRepoVille()
    {
    return $this -> getDoctrine() -> getRepository( Ville::class );
    }


    /**
     *@Route("/{id}", name="lieu_by_id")
     */
    public function RuelieuById($id= '',EntityManagerInterface $em, LieuxRepository $lieuxRepository, SerializerInterface $serializer){
        $lieu = $lieuxRepository->findOneBy(array('id'=>$id));

        $response = new Response($serializer->serialize($lieu,'json'));
        $response->headers->set('Content-Type','application/json');
        return $response;
    }





}
