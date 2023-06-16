<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'firstName' => 'Seb',

        ]);
    }

    #[Route('/cesar', name: 'app_cesar')]
    public function cesar(): Response
    {
        $userName = "Cesar";
        $nbLegion = 2000;
        return $this->render('main/cesar.html.twig', [
            "userName" => $userName,
            "nbLegion" => $nbLegion,
    ]);
    }
}
