<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/wish')]

class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list', methods: ['GET'])]
    public function list(WishRepository $wishRepo): Response
    {
        $wishes = $wishRepo->findAll();
        return $this->render('wish/list.html.twig', ["wishes"=>$wishes]);
    }
    #[Route('/detail/{id}', name: 'wish_detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function detail(Wish $wish): Response
    {
        dump($wish);
        return $this->render('wish/detail.html.twig', ["wish"=>$wish]);
    }

}
