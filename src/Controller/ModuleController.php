<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }

    
    // ********************************************* add edit and delete a module *********************** //
    #[Route('/module/{idCategory}/addModule', name: 'add_module')]
    public function addModule(ManagerRegistry $doctrine, $idCategory, Module $module = null, Request $request)
    {

        $module = new Module();

        $repo = $doctrine->getRepository(Category::class); //get the repo from session
        $category = $repo->find($idCategory); //find the id of the session

        // create a form that refers to the builder in employeType
        $form = $this->createForm(ModuleType::class, $module);
        $form ->handleRequest($request); //analyse whats in the request / gets the data

        // if the form is submitted and check security 
        if ($form->isSubmitted() && $form->isValid()) {

            $module = $form->getData(); // get the data submitted in form and hydrate the object 

            $module->setCategory($category); //set the id from the form into the variable program

            // need the doctrine manager to get persist and flush
            $entityManager = $doctrine->getManager(); 
            $entityManager->persist($module); // prepare
            $entityManager->flush(); // execute

            // redirect to list employe
            return $this->redirectToRoute('detail_module', ['id' => $idCategory]);
        }

        // vue to show form
        return $this->render('program/addModule.html.twig', [
            'formAddModule'=> $form->createView(),   
        ]);
    }


    #[Route('/module/{id}/editModule', name: 'edit_module')]
    public function edit(ManagerRegistry $doctrine,Request $request)
    {
        $id = $request->get('id');
        $module = $doctrine->getRepository(Module::class)->find($id);

        // create a form that refers to the builder in employeType
        $form = $this->createForm(ModuleType::class,$module);
        $form->handleRequest($request);

        // if the form is submitted and check security
        if($form->isSubmitted() && $form->isValid()){
            
            $em = $doctrine->getManager();
            $categoryData = $form->getData();
            $em->persist($categoryData);
            $em->flush();

            return $this->redirectToRoute('detail_module',['id'=>$module->getCategory()->getId()]);

        }

        return $this->render('program/addModule.html.twig',array(
            'formAddModule'=> $form->createView(),   
        ));
    }


    #[Route('/module/{id}/deleteModule', name: 'delete_module')]
    public function deleteModule(ManagerRegistry $docrine, Module $module):Response
    {
        $entityManager = $docrine->getManager();
        $entityManager->remove($module); //remove in object
        $entityManager->flush(); // send the request to the db 

        return $this->redirectToRoute('app_module');

    }
}
