<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }


    // ********************************************* add edit and delete a category *********************** //
    #[Route('/category/add', name: 'add_category')]
    #[Route('/category/{id}/edit', name: 'edit_category')]
    public function addCategory(ManagerRegistry $docrine, Category $category = null, Request $request, FileUploader $fileUploader)
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

            // image upload 
            $image = $form->get('image')->getData(); // get the image data
            if ($image) { // if the image is uploaded
                $imageFileName = $fileUploader->upload($image); // upload the image
                $category->setImage($imageFileName); // set the image
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


    #[Route('/category/{id}/delete', name: 'delete_category')]
    public function delete(ManagerRegistry $docrine, Category $category):Response
    {
        $entityManager = $docrine->getManager();
        $entityManager->remove($category); //remove in object
        $entityManager->flush(); // send the request to the db 

        return $this->redirectToRoute('app_module');

    }
}
