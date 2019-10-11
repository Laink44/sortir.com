<?php

namespace App\Controller\Web;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Participant;
use App\Dto\RequestFindSeries;
use App\Entity\Sortie;
use App\Form\CreateSortieType;
use App\Form\FindSorties;
use App\Repository\EtatsRepository;
use App\Repository\SitesRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie")
 */
class SortieController extends Controller
{
    /**
     * @Route("/create",name="create_sortie")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function create(EntityManagerInterface $em,
                             Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $sortie = new Sortie();

        $OrganisateurEncours= $this->getUser();
        $SiteOrganisateur = $em->getRepository('App:Site')->find($OrganisateurEncours->getSite()->getId());

       $nomSiteParticicpant = $em->getRepository('App:Site')->find($OrganisateurEncours->getSite()->getId())->getNomSite();
       $CPVilleOrganisateur = $em->getRepository('App:Ville')->findOneBy([
          'nomVille'=> $nomSiteParticicpant
       ])->getCodePostal();

        $sortieForm = $this->createForm(CreateSortieType::class, $sortie,[
            'cpville'=>substr($CPVilleOrganisateur,0,2).'%',
        ]) ;

        $sortieForm->handleRequest($request);



        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            if($sortieForm->get('save')->isClicked()){
                // permet de recuperer l'etat associé a un libelle
                $etat =$em->getRepository(Etat::class)->findOneBy(array('libelle' => 'Créée'));
                $sortie->setDescriptioninfos(strip_tags($sortie->getDescriptioninfos()));
                $sortie_alert= "La sortie est sauvegardé";

            }else{
                // permet de recuperer l'etat associé a un libelle
                $etat =$em->getRepository(Etat::class)->findOneBy(array('libelle' => 'Ouverte'));
                $sortie_alert= "La sortie est publié";

            }


           $escapeDescription = str_replace('<p>','',$sortie->getDescriptioninfos());
           $sortie->setDescriptioninfos(str_replace('</p>','',$escapeDescription));

            $sortie->setOrganisateur($OrganisateurEncours);

            $sortie->setEtat($etat);


            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', $sortie_alert);
            return $this->redirectToRoute('sorties',[
            ]);

        }

        return $this->render('sortie/create.html.twig', [
            'siteParticipantEncours' => strtoupper($nomSiteParticicpant),
            'organisateur' => $SiteOrganisateur,

            "form" => $sortieForm->createView()]);
    }

    /**
     * @Route("/edit/{id}",name="sortie_edit", requirements={"id"="\d+"},methods={"POST","GET"})
     * @param $id
     * @param EntityManager $em
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function edit($id,EntityManagerInterface $em,
                           Request $request)
    {
        $sortie = $em->getRepository('App:Sortie')->find($id);
        if ($sortie == null) {
            throw $this->createNotFoundException('La Sortie n\'est pas référencée');

        }

        $ParticipantEnCoursID = $this->getUser()->getSite()->getId();

        //Check si l'organisateur est bien le propriétaire de la sortie
        if($sortie->getOrganisateur() != $this->getUser()){
            return  $this->redirectToRoute('sorties');
        }


        $nomSiteParticicpant = $em->getRepository('App:Site')->find($ParticipantEnCoursID)->getNomSite();





        $CPVilleOrganisateur = $em->getRepository('App:Ville')->findOneBy([
            'nomVille'=> $nomSiteParticicpant
        ])->getCodePostal();

        $SortieForm = $this->createForm('App\Form\CreateSortieType', $sortie,[
           'cpville'=>substr($CPVilleOrganisateur,0,2).'%'



        ]);

        $SortieForm->get('ville')->setData($sortie->getLieu()->getVille());
        $SortieForm->get('lieu')->setData($sortie->getLieu());


        $SortieForm->handleRequest($request);



        if ($SortieForm->isSubmitted() && $SortieForm->isValid()) {
            if ($SortieForm->get('save')->isClicked()) {
                // permet de recuperer l'etat associé a un libelle
                $etat = $em->getRepository(Etat::class)->findOneBy(array('libelle' => 'Créée'));
                $sortie_alert = "La sortie est sauvegardé";

            } else{
                // permet de recuperer l'etat associé a un libelle
                $etat = $em->getRepository(Etat::class)->findOneBy(array('libelle' => 'Ouverte'));
                $sortie_alert = "La sortie est publié";

            }
            $sortie->setDescriptioninfos(strip_tags($sortie->getDescriptioninfos()));
            $sortie->setEtat($etat);

            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', $sortie_alert);
            return $this->redirectToRoute('sorties');

        }
        return $this->render("sortie/edit.html.twig", [
            "sortie"=>$sortie,
            "form" => $SortieForm->createView(),

        ]);
    }


    /**
     * @Route("/edit/{id}", name="sortie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em, $id){
        $sortie = $em->getRepository('App:Sortie')->find($id);
        if ($sortie == null) {
            throw $this->createNotFoundException('La Sortie n\'est pas référencée ou a été supprimé');

        }
        if ($this->isCsrfTokenValid('delete'.$sortie->getId(),
            $request->request->get('_token'))) {
            $em->remove($sortie);
            $em->flush();
            $this->addFlash('success', "La sortie a été supprimé");
        }
        return $this->redirectToRoute('sorties');

    }






    /**
     * @Route(
     * "/",
     * name="sorties",
     * methods={"GET"}
     * )
     * @param PaginatorInterface $paginator
     * @param SortiesRepository $sortiesRepository
     * @param Request $request
     * @return Response
     */
    public function sorties(PaginatorInterface $paginator, SortiesRepository $sortiesRepository,SitesRepository $sitesRepository, Request $request){
        $dto = new RequestFindSeries();
        $form = $this->createForm(FindSorties::class, $dto, array(
            'action' => $this->generateUrl($request->get('_route'))
        ));
        $allSorties = $sortiesRepository->findAllOpened(null, $this->getUser());
        $allSites = $sitesRepository->findAllSites();
        return $this->render('sortie/index.html.twig', [
            'allSites' => $allSites,
            'form' => $form->createView(),
            'allSorties' => $allSorties,
            ]);
    }


    /**
     * @Route(
     * "/table",
     * name="table_sorties",
     * )
     * @param PaginatorInterface $paginator
     * @param SortiesRepository $sortiesRepository
     * @param Request $request
     * @return Response
     */
    public function table_sorties(PaginatorInterface $paginator, SortiesRepository $sortiesRepository,SitesRepository $sitesRepository, Request $request){


        /*if ($request->getMethod() == 'GET') {
            $allSorties = $sortiesRepository->findAll();
            $allSites = $sitesRepository->findAllSites();
            return $this->render('sortie/sorties_table.html.twig', [
                'allSites' => $allSites,
                'allSorties'
                => $this->getPaginatedList($allSorties, $paginator, $request ),
            ]);
        }*/
        $dto = new RequestFindSeries();
        $form = $this->createForm(FindSorties::class, $dto, array(
            'action' => $this->generateUrl($request->get('_route'))
        ));
        $form->handleRequest($request);
        $allSites = $sitesRepository->findAllSites();
        if ($form->isSubmitted() && $form->isValid()) {
            $allSorties = $sortiesRepository->findAllOpened($dto, $this->getUser());
            return $this->render('sortie/sorties_table.html.twig', [
                'allSites' => $allSites,
                'allSorties' => $allSorties
            ]);
        }
        $allSorties = $sortiesRepository->findAllOpened(null, $this->getUser());
        return $this->render('sortie/sorties_table.html.twig', [
            'allSites' => $allSites,
            'allSorties' => $allSorties,
        ]);

    }


    /**
     * @Route("/{id}",name="sortie_detail",requirements={"id"="\d+"}, methods={"POST","GET"})
     */
    public function detail($id, Request $request){
        // récupérer la fiche Sortie dans la base de données
        $SortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $SortieRepo->find($id);
        if($sortie==null){
            throw $this->createNotFoundException('La sortie n\'existe pas');
        }
        return $this->render('sortie/detail.html.twig',[
            'sortie'=>$sortie,
        ]);

    }


    /**
     * @Route("/unregister",name="sortie_unregister", methods={"POST"})
     */
    public function Unsubscribe(Request $request, EntityManagerInterface $entityManager){
        // récupérer la fiche Sortie dans la base de données
        $SortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $SortieRepo->find($request->request->get("sortie"));
        $submittedToken =$request->request->get("table_csrf_token");
        if (!$this->isCsrfTokenValid('table_csrf_token_JFN4F4if', $submittedToken)) {
            throw $this->createAccessDeniedException('Error unexpected');
        }
        if($sortie==null){
            throw $this->createNotFoundException('La sortie n\'existe pas');
        }
        foreach($this->getUser()->getInscriptions() as $inscription){
            if ($sortie->getInscriptions()->contains($inscription)){
                $entityManager->remove($inscription);
            }
        }
        if($sortie->getEtat()->getLibelle() != 'Ouverte'){
            throw $this->createNotFoundException('La sortie ne peut être modifié dans l\'état actuel');
        }
        $entityManager->flush();
        return $this->redirectToRoute("table_sorties");

    }


    /**
     * @Route("/register",name="sortie_register", methods={"POST"})
     */
    public function subscribe(Request $request, EntityManagerInterface $entityManager){
        // récupérer la fiche Sortie dans la base de données
        $SortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $SortieRepo->find($request->request->get("sortie"));
        $submittedToken =$request->request->get("table_csrf_token");
        if (!$this->isCsrfTokenValid('table_csrf_token_JFN4F4if', $submittedToken)) {
            throw $this->createAccessDeniedException('Error unexpected');
        }
        if($sortie==null){
            throw $this->createNotFoundException('La sortie n\'existe pas');
        }
        if($sortie->getEtat()->getLibelle() != 'Ouverte'){
            throw $this->createNotFoundException('La sortie ne peut être modifié dans l\'état actuel');
        }
        if($sortie->getInscriptions()->count() >= $sortie->getNbinscriptionsmax()){
            throw $this->createNotFoundException('Le nombre maximum d\'inscription à été ateint.');
        }
        foreach($this->getUser()->getInscriptions() as $inscription){
            if ($sortie->getInscriptions()->contains($inscription)){
                $entityManager->remove($inscription);
            }
        }
        $new_inscription = new Inscription();
        $new_inscription->setSortie($sortie);
        $new_inscription->setParticipant($this->getUser());
        $new_inscription->setDate(new \DateTime ());
        $sortie->addInscription($new_inscription);
        $entityManager->flush();
        return $this->redirectToRoute("table_sorties");

    }

    /**
     * @Route("/cancel",name="sortie_cancel", methods={"POST"})
     */
    public function Cancel(Request $request, EtatsRepository $etatsRepository, EntityManagerInterface $entityManager){
        // récupérer la fiche Sortie dans la base de données
        $SortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $SortieRepo->find($request->request->get("sortie"));
        $submittedToken =$request->request->get("table_csrf_token");
        if (!$this->isCsrfTokenValid('table_csrf_token_JFN4F4if', $submittedToken)) {
            throw $this->createAccessDeniedException('Error unexpected');
        }
        $cancelState = $etatsRepository->findOneBy(array('libelle' => "Annulée"));
        if($sortie==null){
            throw $this->createNotFoundException('La sortie n\'existe pas');
        }
        if($sortie->getEtat()->getLibelle() != 'Ouverte' & $sortie->getEtat()->getLibelle() != 'Créee'){
            throw $this->createNotFoundException('La sortie ne peut être modifié dans l\'état actuel');
        }
        $sortie->setEtat($cancelState);
        $entityManager->persist($sortie);
        $entityManager->flush();
        return $this->redirectToRoute("table_sorties");

    }


    public function getPaginatedList( Array $listOfObjectsToPaginate, PaginatorInterface $paginator, Request $request )
    {
        $paginatedObjects = $paginator -> paginate(
            $listOfObjectsToPaginate,
            $request -> query -> getInt( 'page', 1 ),
            10
        );

        $paginatedObjects -> setTemplate( 'pagination/twitter_bootstrap_v4_pagination.html.twig' );
        $paginatedObjects -> setUsedRoute( 'sorties' );

        return $paginatedObjects;
    }



    public function getEm() {
        return $this -> getDoctrine() -> getManager();
    }
    public function getRepo($class)
    {
        return $this -> getDoctrine() -> getRepository( $class );
    }
}
