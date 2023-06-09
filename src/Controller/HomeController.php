<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\ProgramType;
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




    #[Route('/home/{idSession}/add', name: 'add_program')]
    public function addProgram(ManagerRegistry $doctrine, $idSession, Program $program = null, Request $request): Response
    {
    
        $program = new Program();

        $repo = $doctrine->getRepository(Session::class); //get the repo from session
        $session = $repo->find($idSession); //find the id of the session


        // create a form that refers to the builder in employeType
        $form = $this->createForm(ProgramType::class);
        
        $form ->handleRequest($request); //analyse whats in the request / gets the data
        
        // if the form is submitted and check security 
        if ($form->isSubmitted() && $form->isValid()) {
            
            $program = $form->getData(); // get the data submitted in form and hydrate the object 
           
            $program->setSession($session); //set the id from the form into the variable program
            
            // need the doctrine manager to get persist and flush
            $entityManager = $doctrine->getManager(); 
            $entityManager->persist($program); // prepare
            $entityManager->flush(); // execute

            // redirect to list employe
            return $this->redirectToRoute('detail_session',['id'=>$idSession]);
        }

        // vue to show form
        return $this->render('home/add.html.twig', [
            'session'=> $session,
            'edit'=> $program->getId(),     
            'formAddProgram'=> $form->createView(),
        ]);
    }

    #[Route('/home/{id}/edit', name: 'edit_program')]
    public function edit(ManagerRegistry $doctrine,Request $request)
    {
        $id = $request->get('id');
        $program = $doctrine->getRepository(Program::class)->find($id);

        // create a form that refers to the builder in employeType
        $form = $this->createForm(ProgramType::class,$program);
        $form->handleRequest($request);

        // if the form is submitted and check security
        if($form->isSubmitted() && $form->isValid()){
            
            $em = $doctrine->getManager();
            $categoryData = $form->getData();
            $em->persist($categoryData);
            $em->flush();

            return $this->redirectToRoute('detail_session',['id'=>$program->getSession()->getId()]);

        }

        return $this->render('home/add.html.twig',array(
            'formAddProgram' => $form->createView(),
        ));
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
    public function detailSession(EntityManagerInterface $entityManager, Session $session):Response
    {

        $stagiaires = $entityManager->getRepository(Stagiaire::class)->findInternsNotInSession($session->getId());

        return $this->render('session/detailSession.html.twig', [
            'session'=> $session,
            "stagiaires" => $stagiaires,
        ]);
    }

}
