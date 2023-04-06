<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(): Response
    {
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }


    #[Route('/session/add', name: 'add_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function add(ManagerRegistry $docrine, Session $session = null, Request $request)
    {

        // if the entreprise id doesn't exist then create it
        if (!$session) {
            $session = new Session();
        }
        // else edit

        // create a form that refers to the builder in employeType
        $form = $this->createForm(SessionType::class, $session);
        $form ->handleRequest($request); //analyse whats in the request / gets the data

        // if the form is submitted and check security 
        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData(); // get the data submitted in form and hydrate the object 

            // need the doctrine manager to get persist and flush
            $entityManager = $docrine->getManager(); 
            $entityManager->persist($session); // prepare
            $entityManager->flush(); // execute

            // redirect to list employe
            return $this->redirectToRoute('app_home');
        }

        // vue to show form
        return $this->render('session/add.html.twig', [

            'formAddSession'=> $form->createView(),   
            'edit'=> $session->getId(),   
        ]);
    }


    #[Route('/session/{id}/delete', name: 'delete_session')]
    public function delete(ManagerRegistry $docrine, Session $session):Response
    {
        $entityManager = $docrine->getManager();
        $entityManager->remove($session); //remove in object
        $entityManager->flush(); // send the request to the db 

        return $this->redirectToRoute('app_home');

    }
}
