<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/wish')]

class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig');
    }
    #[Route('/detail/{id}', name: 'wish_detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function detail(int $id): Response
    {
        dump($id);
        return $this->render('wish/detail.html.twig');
    }

}
