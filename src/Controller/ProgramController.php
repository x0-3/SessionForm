<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Module;
use App\Form\CategoryType;
use App\Form\ModuleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    #[Route('/program', name: 'app_module')]
    public function index(ManagerRegistry $doctrine): Response
    {

        // $module = $doctrine->getRepository(Module::class)->findAll();
        $categories = $doctrine->getRepository(Category::class)->findAll();

        return $this->render('program/index.html.twig', [
            // 'modules' => $module,
            'categories' => $categories,
        ]);
    }


    // ********************************************* add edit and delete a category *********************** //
    #[Route('/program/add', name: 'add_category')]
    #[Route('/program/{id}/edit', name: 'edit_category')]
    public function addCategory(ManagerRegistry $docrine, Category $category = null, Request $request)
    {

        // if the entreprise id doesn't exist then create it
        if (!$category) {
            $category = new Category();
        }
        // else edit

        // create a form that refers to the builder in employeType
        $form = $this->createForm(CategoryType::class, $category);
        $form ->handleRequest($request); //analyse whats in the request / gets the data

        // if the form is submitted and check security 
        if ($form->isSubmitted() && $form->isValid()) {

            $category = $form->getData(); // get the data submitted in form and hydrate the object 

            // need the doctrine manager to get persist and flush
            $entityManager = $docrine->getManager(); 
            $entityManager->persist($category); // prepare
            $entityManager->flush(); // execute

            // redirect to list employe
            return $this->redirectToRoute('app_module');
        }

        // vue to show form
        return $this->render('program/addCategory.html.twig', [

            'formAddCategory'=> $form->createView(),   
            'edit'=> $category->getId(),   
        ]);
    }


    #[Route('/program/{id}/delete', name: 'delete_category')]
    public function delete(ManagerRegistry $docrine, Category $category):Response
    {
        $entityManager = $docrine->getManager();
        $entityManager->remove($category); //remove in object
        $entityManager->flush(); // send the request to the db 

        return $this->redirectToRoute('app_module');

    }

    // ********************************************* add edit and delete a module *********************** //
    #[Route('/program/addModule', name: 'add_module')]
    #[Route('/program/{id}/editModule', name: 'edit_module')]
    public function addModule(ManagerRegistry $docrine, Module $module = null, Request $request)
    {

        // if the entreprise id doesn't exist then create it
        if (!$module) {
            $module = new Module();
        }
        // else edit

        // create a form that refers to the builder in employeType
        $form = $this->createForm(ModuleType::class, $module);
        $form ->handleRequest($request); //analyse whats in the request / gets the data

        // if the form is submitted and check security 
        if ($form->isSubmitted() && $form->isValid()) {

            $module = $form->getData(); // get the data submitted in form and hydrate the object 

            // need the doctrine manager to get persist and flush
            $entityManager = $docrine->getManager(); 
            $entityManager->persist($module); // prepare
            $entityManager->flush(); // execute

            // redirect to list employe
            return $this->redirectToRoute('app_module');
        }

        // vue to show form
        return $this->render('program/addModule.html.twig', [

            'formAddModule'=> $form->createView(),   
            'edit'=> $module->getId(),   
        ]);
    }

    #[Route('/program/{id}/deleteModule', name: 'delete_module')]
    public function deleteModule(ManagerRegistry $docrine, Module $module):Response
    {
        $entityManager = $docrine->getManager();
        $entityManager->remove($module); //remove in object
        $entityManager->flush(); // send the request to the db 

        return $this->redirectToRoute('app_module');

    }










    // 
    #[Route('/program/{id}', name: 'detail_module')]
    public function detail(Module $module, Category $category):Response
    {

        return $this->render('program/detailProgram.html.twig',[
            'module'=> $module,
            'category'=> $category,
        ]);
    }
}
