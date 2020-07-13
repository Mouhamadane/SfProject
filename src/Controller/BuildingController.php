<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\BuildingRepository;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Building;


class BuildingController extends AbstractController
{
    /**
     * @Route("/building", name="building")
     */
    public function index(BuildingRepository $repo, Request $request, PaginatorInterface $paginator)
    {
        $data = $repo->findAll();
        $buildings = $paginator->paginate($data, $request->query->getInt('page',1),5);
        return $this->render('building/index.html.twig', [
            'controller_name' => 'Gestion Bâtiment',
            'buildings' =>$buildings,
        ]);
    }
    /**
     * @Route("/addBuilding", name="addbuilding")
     * @Route("/editBuilding{id}", name="editbuilding")
     * Method({"GET","POST"})
     */
    public function building(Building $building=null, Request $request, EntityManagerInterface $manager )
    {
        if (!$building) {
            $building = new Building();
        }
        $form = $this->createFormBuilder($building)
            ->add('name')
            ->add('nbrRoom')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($building);
            $manager->flush();
            return $this->redirectToRoute('building');

        }
        return $this->render('building/addbuilding.html.twig', [
            'controller_name' => 'Gestion Bâtiment',
            'formBuilding' => $form->createView(),
        ]);
    }
    /**
     * @Route("/building/delete/{id}", name="delete_building")
     * Method('DELETE')
     */
    public function deleteBuilding(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $building = $entityManager->getRepository(Building::class)->find($id);
        dump($building);
        $entityManager->remove($building);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
