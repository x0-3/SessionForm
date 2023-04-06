<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $sessions = $doctrine->getRepository(Session::class)->findAll();

        return $this->render('home/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }    

    #[Route('/home/{id}', name: 'detail_session')]
    public function detailSession(Session $session, ManagerRegistry $doctrine):Response
    {
        return $this->render('session/detailSession.html.twig', [
            'session'=> $session,
        ]);
    }

}
