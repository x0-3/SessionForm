<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Module;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/program/{id}', name: 'detail_module')]
    public function detail(Module $module, Category $category):Response
    {

        return $this->render('program/detailProgram.html.twig',[
            'module'=> $module,
            'category'=> $category,
        ]);
    }
}
