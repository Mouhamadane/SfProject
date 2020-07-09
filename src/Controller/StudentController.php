<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use App\Form\StudentType;
use App\Entity\Student;
use App\Entity\Room;
use App\Entity\Building;
use App\Controller\RoomController;
use App\Repository\StudentRepository;
use DateTime;

class StudentController extends AbstractController
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
                return $number;
            } 
        }

    }

    private function genereMat($id,$firstName,$lastName)
    {
        $date       = new \DateTime;
        $year   = $date->format('Y');
        $subs1 = substr($firstName,0,2);
        $subs2 = substr($lastName,0,2);
        $nbr = $this->generate($id);
        return $year."-".strtoupper($subs1)."-".strtoupper($subs2)."-".$nbr;
         
    }
    /**
     * @Route("/student", name="student")
     * @Roue("/editStudent/{id}", name="editStudent")
     * Method("GET","POST")
     */
    public function index(Student $student, StudentRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        // nombre etudiants sur la base
        $students = $repo->findAll();
        $nbr = count($students);
        // gerer form
        $student = new Student;
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // gestion du matricule
            $firstName = $student->getfisrtName();
            $lastName = $student->getlastName();
            $matricule = $this->genereMat($nbr+1,$firstName,$lastName);
            $student->setMatricule($matricule);
            // fin gestion lol
            //date inscription
            $student->setDateInscription(new \DateTime);
            $manager->persist($student);
            $manager->flush();
            return $this->redirectToRoute('listStudent');
        }
        return $this->render('student/index.html.twig', [
            'controller_name' => 'Gérer Etudiant',
            'form'=>$form->createView(),
        ]);
    }
     /**
     * @Route("/listStudent", name="listStudent")
     */
    public function listStudent(StudentRepository $repo)
    {
        $students = $repo->findAll();
        return $this->render('student/listStudent.html.twig', [
            'controller_name' => 'Gérer Etudiant',
            'students' => $students,
        ]);
    }
}
