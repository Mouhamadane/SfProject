<?php

namespace App\Controller;

use App\Entity\Building;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Room;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\BuildingRepository;
use App\Form\RoomType;


class RoomController extends AbstractController
{
    public function generate($number){

        if (preg_match("# [0-9]{4}#",$number)) {
            return "-".$number;
        }else {
            $newNumber = (string)$number;
            $long = strlen($newNumber);
            if ($long<4) {
                $restant = 4-$long;
                for ($i=0; $i <$restant ; $i++) { 
                    $number = "0".$number;
                }
                return "-".$number;
            } 
        }

    }
    public function generateNumRoom($number,$number1){
        $number = $this->generate($number);
        return $number1."".$number;
    }
    /**
     * @Route("/room", name="room")
     */
    public function index(Request $request,RoomRepository $repo,PaginatorInterface $paginator)
    {
        $data = $repo->findAll();
        $rooms =  $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        return $this->render('room/index.html.twig', [
            'controller_name' => 'Gestion Chambre',
            'rooms' =>$rooms,
        ]);
    }
    /**
     * @Route("/addRoom", name="ajouterChambre")
     * @Route("/editRoom/{id}", name="editRoom")
     * Method("GET","POST")
     */
    public function formRoom( RoomRepository $repo, Room $room = null, Request $request, EntityManagerInterface $manager)
    { 

        $rooms = $repo->findAll();
        $nbr = count($rooms);
        if (!$room) {
            $room = new Room();
        }
       
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // Generation du numero de chambre
            $numBuilding = $room->getBuilding()->getId();
            $gerate = $this->generateNumRoom($nbr+1,$numBuilding);
            $room->setMatricule($gerate);
            // Ajouter sur la base de données
            $manager->persist($room);
            $manager->flush();
            // Redirection sur la liste des chambres
            return $this->redirectToRoute('room');

        }
        return $this->render('room/addroom.html.twig', [
            'controller_name' => 'Gestion Chambre',
            'form' =>$form->createView(),
        ]);
    }
     /**
     * @Route("/room/delete/{id}", name="delete_room")
     * Method('DELETE')
     */
    public function deleteRoom(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $room = $entityManager->getRepository(Room::class)->find($id);
        $entityManager->remove($room);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
