<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index()
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
     /**
     * @Route("/listStudent", name="listStudent")
     */
    public function listStudent()
    {
        return $this->render('student/listStudent.html.twig', [
            'controller_name' => 'Liste Etudiant',
        ]);
    }
}
