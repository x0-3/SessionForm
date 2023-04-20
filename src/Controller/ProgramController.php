<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Module;
use App\Form\CategoryType;
use App\Form\ModuleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function addCategory(ManagerRegistry $docrine, Category $category = null, Request $request, SluggerInterface $slugger)
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


            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('category_directory'),  
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $category->setImage($newFilename);
            }

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
    #[Route('/program/{idCategory}/addModule', name: 'add_module')]
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


    #[Route('/program/{id}/editModule', name: 'edit_module')]
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


    #[Route('/program/{id}/deleteModule', name: 'delete_module')]
    public function deleteModule(ManagerRegistry $docrine, Module $module):Response
    {
        $entityManager = $docrine->getManager();
        $entityManager->remove($module); //remove in object
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
