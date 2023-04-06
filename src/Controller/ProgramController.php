<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Program;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    #[Route('/program', name: 'app_module')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $module = $doctrine->getRepository(Module::class)->findAll();

        return $this->render('program/index.html.twig', [
            'modules' => $module,
        ]);
    }

    #[Route('/program/{id}', name: 'detail_module')]
    public function detail(Module $module, Program $program):Response
    {

        return $this->render('program/detailProgram.html.twig',[
            'module'=> $module,
            'program'=> $program,
        ]);
    }
}
