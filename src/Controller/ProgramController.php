<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Module;
use App\Entity\Program;
use App\Form\CategoryType;
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


    #[Route('/program/add', name: 'add_category')]
    #[Route('/program/{id}/edit', name: 'edit_category')]
    public function add(ManagerRegistry $docrine, Category $category = null, Request $request)
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


    #[Route('/program/{id}', name: 'detail_module')]
    public function detail(Module $module, Category $category):Response
    {

        return $this->render('program/detailProgram.html.twig',[
            'module'=> $module,
            'category'=> $category,
        ]);
    }
}
