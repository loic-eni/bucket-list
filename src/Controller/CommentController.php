<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Wish;
use App\Form\CommentType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/add/{wishId}', name: 'comment_add', requirements: ['wishId'=>'\d+'])]
public function add(int $wishId, Request $request, EntityManagerInterface $manager): Response
{
    $comment = new Comment();
    $commentForm = $this->createForm(CommentType::class, $comment);

    $commentForm->handleRequest($request);

    if($commentForm->isSubmitted() && $commentForm->isValid()){
        $comment->setUser($this->getUser());
        $wish = $manager->getRepository(Wish::class)->find($wishId);
        $comment->setWish($wish);

        $manager->persist($comment);
        $manager->flush();

        $this->addFlash('success', 'Successfully created new comment');
        return $this->redirectToRoute('wish_detail', ['id'=>$wishId]);
    }

    return $this->render('comment/add.html.twig', ['commentForm'=>$commentForm]);
}

    #[Route('/comment/edit/{id}', name: 'comment_edit', requirements: ['id'=>'\d+'])]
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager): Response
    {
        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Successfully created new comment');
            return $this->redirectToRoute('wish_detail', ['id'=>$comment->getWish()->getId()]);
        }

        return $this->render('comment/edit.html.twig', ['commentForm'=>$commentForm]);
    }

    #[Route('/comment/delete/{id}', name: 'comment_delete', requirements: ['id'=>'\d+'])]
    public function delete(Comment $comment, EntityManagerInterface $manager){
        $manager->remove($comment);
        $manager->flush();
        return $this->redirectToRoute('wish_detail', ['id'=>$comment->getWish()->getId()]);
    }
}
