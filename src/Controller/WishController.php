<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
USE \Symfony\Component\HttpFoundation\RedirectResponse;
#[Route('/wish')]

class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list', methods: ['GET'])]
    #[Route('/list', name: 'app_home', methods: ['GET'])]
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

    #[Route('/add', name:'wish_add', methods:['GET', 'POST'])]
public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
            $wish->setUser($this->getUser());
            $entityManager->persist($wish);
            $entityManager->flush();
            $this->addFlash('success', 'Idea successfully added');
            return $this->redirectToRoute("wish_detail", ['id'=>$wish->getId()]);
        }

        return $this->render("wish/add.html.twig", ["wishForm"=>$wishForm]);
    }

    #[Route("/update/{id}", name:"wish_update", methods: ['GET', 'POST'])]
    public function update(EntityManagerInterface $entityManager, Request $request, Wish $wish): Response
    {
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
             $entityManager->persist($wish);
             $entityManager->flush();
             $this->addFlash("success", "Idea edited successfully");
             return $this->redirectToRoute("wish_detail", ["id"=>$wish->getId()]);
        }

        return $this->render("wish/update.html.twig", ['wishForm'=>$wishForm]);
    }

    #[Route("/delete/{id}", name:"wish_delete", methods: ['get'])]
    public function delete(Wish $wish, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($wish);
        $entityManager->flush();
        $this->addFlash("success", "Idea successfully deleted forever");
        return $this->redirectToRoute("home");
    }

}
