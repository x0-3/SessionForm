<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\ProgramType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $sessions = $doctrine->getRepository(Session::class)->findAll();

        return $this->render('home/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }    




    #[Route('/home/add', name: 'add_program')]
    #[Route('/home/{id}/edit', name: 'edit_program')]
    public function addProgram(ManagerRegistry $doctrine, Program $program = null, Request $request): Response
    {

        // if the entreprise id doesn't exist then create it
        if (!$program) {
            
            $program = new Program();
        }
        // else edit

        // $sessionId = $request->attributes->get('session');

        // create a form that refers to the builder in employeType
        $form = $this->createForm(ProgramType::class, 
        // $program, ['session' => $sessionId]
        );

        $form ->handleRequest($request); //analyse whats in the request / gets the data

        // if the form is submitted and check security 
        if ($form->isSubmitted() && $form->isValid()) {

            $program = $form->getData(); // get the data submitted in form and hydrate the object 
            
            // need the doctrine manager to get persist and flush
            $entityManager = $doctrine->getManager(); 
            $entityManager->persist($program); // prepare
            $entityManager->flush(); // execute

            // redirect to list employe
            return $this->redirectToRoute('detail_session',['id'=>$program->getSession()->getId()]);
        }

        // vue to show form
        return $this->render('home/add.html.twig', [
            'formAddProgram'=> $form->createView(),   
            'edit'=> $program->getId(),     
        ]);
    }



    #[Route('/home/{id}/delete', name: 'delete_program')]
    public function delete(ManagerRegistry $doctrine, Program $program):Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($program); //remove in object
        $entityManager->flush(); // send the request to the db 

        return $this->redirectToRoute('detail_session',['id'=>$program->getSession()->getId()]);

    }

    #[Route('/home/{id}', name: 'detail_session')]
    public function detailSession(EntityManagerInterface $entityManager, Session $session, Stagiaire $stagiaires):Response
    {

        $stagiaires = $entityManager->getRepository(Stagiaire::class)->findInternsNotInSession($session->getId());

        return $this->render('session/detailSession.html.twig', [
            'session'=> $session,
            "stagiaires" => $stagiaires,
        ]);
    }

}
