<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', 'home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig', ['serie'=>['name'=>'Arcane', 'year'=>2024, 'director'=>'Riot games']]);
    }

    #[Route('/about', 'about')]
    public function about(): Response{
        return $this->render('main/about.html.twig');
    }
}
