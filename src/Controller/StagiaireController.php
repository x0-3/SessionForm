<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $stagiaires = $doctrine->getRepository(Stagiaire::class)->findAll();

        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }


    #[Route('/stagiaire/add', name: 'add_stagiaire')]
    #[Route('/stagiaire/{id}/edit', name: 'edit_stagiaire')]
    public function add(ManagerRegistry $docrine, Stagiaire $stagiaire = null, Request $request)
    {

        // if the entreprise id doesn't exist then create it
        if (!$stagiaire) {
            $stagiaire = new Stagiaire();
        }
        // else edit

        // create a form that refers to the builder in employeType
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form ->handleRequest($request); //analyse whats in the request / gets the data

        // if the form is submitted and check security 
        if ($form->isSubmitted() && $form->isValid()) {

            $stagiaire = $form->getData(); // get the data submitted in form and hydrate the object 

            // need the doctrine manager to get persist and flush
            $entityManager = $docrine->getManager(); 
            $entityManager->persist($stagiaire); // prepare
            $entityManager->flush(); // execute

            // redirect to list employe
            return $this->redirectToRoute('app_stagiaire');
        }

        // vue to show form
        return $this->render('stagiaire/add.html.twig', [

            'formAddStagiaire'=> $form->createView(),   
            'edit'=> $stagiaire->getId(),   
        ]);
    }


    #[Route('/stagiaire/{id}/delete', name: 'delete_stagiaire')]
    public function delete(ManagerRegistry $docrine, Stagiaire $stagiaire):Response
    {
        $entityManager = $docrine->getManager();
        $entityManager->remove($stagiaire); //remove in object
        $entityManager->flush(); // send the request to the db 

        return $this->redirectToRoute('app_stagiaire');

    }



    #[Route('/stagiaire/{id}', name: 'detail_stagiaire')]
    public function detail(Stagiaire $stagiaire): Response
    {

        return $this->render('stagiaire/detail.html.twig',[
            'stagiaire'=>$stagiaire,
        ]);

    }

}
