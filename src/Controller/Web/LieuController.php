<?php

namespace App\Controller\Web;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Repository\LieuxRepository;
use App\Repository\VillesRepository;
use App\Service\PaginatorService;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends Controller
{
    const ORIGIN_HOME = 'home';
    const ORIGIN_PAGINATOR = 'paginator';
    const ORIGIN_SEARCHBAR = 'searchbar';
    const ORIGIN_REMOVE = 'remove';
    const ORIGIN_ADD = 'add';
    const ORIGIN_EDIT = 'edit';

    /**
     * @Route(
     * "/admin/lieu",
     * name="gestion_lieu",
     * methods={"GET"}
     * )
     */
    public function adminLieu(
        PaginatorInterface $paginator,
        Request $request,
        LieuxRepository $lieuxRepo,
        PaginatorService $paginatorService
    )
    {
        $search = $request->query->get('search', '');
        $origin = $request->query->get('origin', self::ORIGIN_HOME);
        $currentPage = $request->query->get('currentpage', 1);
        $destination = 'admin/admin_lieu.html.twig';
        switch ($origin) {
            case self::ORIGIN_HOME :
                $destination = 'admin/admin_lieu.html.twig';
                break;
            case self::ORIGIN_PAGINATOR :
            case self::ORIGIN_SEARCHBAR :
            case self::ORIGIN_REMOVE :
            case self::ORIGIN_ADD :
            case self::ORIGIN_EDIT :
                dump( "I'M IN" );
                $destination = 'admin/admin_lieu_table.html.twig';
                break;
            default:
                $destination = 'home.html.twig';
                break;
        }

        // NOMBRE DE LIEUX
        // Dénombre les lieux de la table idoine, ce qui sera utile pour l'évaluation de la variable offset
        $rowCount = 0;
        if (
            ($origin == self::ORIGIN_SEARCHBAR || $origin == self::ORIGIN_PAGINATOR)
            && $search
            && $search != ''
            && $search != 'empty'
        ) {
            $rowCount = $lieuxRepo->getLocationCountByName($search);
        } else {
            $rowCount = $lieuxRepo->getLocationCount();
        }

        // PARAMETRES DE PAGINATION
        $maxByPage = 15;
        $numberOfRange = 5;
        $viewParams = $paginatorService->getViewParams($currentPage, $maxByPage, $rowCount, $numberOfRange);
        $offset = $paginatorService->getOffset($currentPage, $maxByPage);

        // LISTE DE VILLES
        $allLieux = [];
        if (
            ($origin == self::ORIGIN_SEARCHBAR || $origin == self::ORIGIN_PAGINATOR)
            && $search
            && $search != ''
            && $search != 'empty'
        ) {
            $allLieux = $lieuxRepo->getByLocationName($search, $offset, $maxByPage);
        } else {
            $allLieux = $lieuxRepo->findAllLieux($offset, $maxByPage);
        }
        dump( $destination );
        dump( $allLieux );
        return $this->render($destination, [
            'allLieux' => $this->getPaginatedList($allLieux, $paginator, $request),
            'viewParams' => $viewParams
        ]);
    }

    /**
     * @Route(
     * "/admin/lieu/ajouter",
     * name="lieu_add",
     * methods={"GET"}
     * )
     */
    public function addLieu(
        PaginatorInterface $paginator,
        Request $request,
        VillesRepository $villeRepo
    )
    {
        $ville = $villeRepo -> find( $request->query->get('villeid') );

        $newLieu = new Lieu();
        $newLieu->setNomLieu($request->query->get('nom', ''));
        $newLieu->setRue($request->query->get('rue', ''));
        $newLieu->setLatitude($request->query->get('latitude', ''));
        $newLieu->setLongitude($request->query->get('longitude', ''));
        $newLieu->setVille($ville);

        $this->getEm()->persist($newLieu);
        $this->getEm()->flush();

        return $this->redirectToRoute('gestion_lieu', $request->query->all());
    }

    /**
     * @Route(
     * "/admin/lieu/supprimer",
     * name="lieu_remove",
     * methods={"GET"}
     * )
     */
    public function removeLieu(
        PaginatorInterface $paginator,
        Request $request,
        LieuxRepository $lieuxRepo
    )
    {
        $lieuToRemove = $lieuxRepo->find($request->query->get('id'));
        $this->getEm()->remove($lieuToRemove);
        $this->getEm()->flush();

        return $this->redirectToRoute( 'gestion_lieu', $request -> query -> all() );
    }

    /**
     * @Route(
     * "/admin/lieu/editer",
     * name="lieu_edit",
     * methods={"GET"}
     * )
     */
    public function editLieu(
        PaginatorInterface $paginator,
        Request $request,
        LieuxRepository $lieuxRepo
    )
    {
        $lieuToEdit = $lieuxRepo -> find($request->query->get('id'));
        $lieuToEdit->setNomLieu($request->query->get('nom', ''));
        $lieuToEdit->setRue($request->query->get('rue', ''));
        $lieuToEdit->setLatitude($request->query->get('latitude', ''));
        $lieuToEdit->setLongitude($request->query->get('longitude', ''));
        $this->getEm()->persist($lieuToEdit);
        $this->getEm()->flush();

        return $this->redirectToRoute('gestion_lieu', $request->query->all());
    }

//    /**
//     * @Route(
//     * "/admin/lieu/search/nom",
//     * name="lieu_search",
//     * methods={"GET"}
//     * )
//     */
//    public function searchLieu($nomLieu = '', PaginatorInterface $paginator, Request $request, LieuxRepository $lieuxRepo )
//    {
//        $foundLocations = $lieuxRepo -> getByLocationName( $request->query->get('search'), 0, 5);
//
//        if ($nomLieu === 'empty') {
//            $foundLocations = $lieuxRepo -> findAllLieux();
//        }
//
//        return $this->render('admin/admin_lieu_table.html.twig', [
//            'allLieux' => $this->getPaginatedList($foundLocations, $paginator, $request)
//        ]);
//    }

    public function getAllLieux()
    {
        return $this->getRepo()->findAll();
    }

    public function getPaginatedList(Array $listOfObjectsToPaginate, PaginatorInterface $paginator, Request $request)
    {
        $paginatedObjects = $paginator->paginate($listOfObjectsToPaginate);

        $paginatedObjects->setTemplate('pagination/pagination.html.twig');
        $paginatedObjects->setUsedRoute('gestion_lieu');

        return $paginatedObjects;
    }

    public function getEm()
    {
        return $this->getDoctrine()->getManager();
    }
}