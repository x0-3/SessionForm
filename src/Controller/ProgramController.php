<?php

namespace App\Controller;

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

        $module = $doctrine->getRepository(Module::class)->findAll();

        return $this->render('program/index.html.twig', [
            'modules' => $module,
        ]);
    }
}
