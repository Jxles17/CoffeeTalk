<?php

// src/Controller/ArticleController.php
namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use DateTime;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[IsGranted('ROLE_ADMIN')]
class ArticleController extends AbstractController
{
    #[Route('/admin/articles', name: 'article.index')]
    public function index(ArticleRepository $repository): Response
    {
        $articles = $repository->findAll();
        return $this->render('article/index.html.twig', compact('articles'));
    }

    #[Route('/admin/articles/{id}', name: 'article.show', requirements: ['id' => '\d+'])]
    public function show(Request $request, int $id, ArticleRepository $repository): Response
    {
        $article = $repository->find($id);
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/admin/articles/{id}/edit', name: 'article.edit', methods: ['GET', 'POST'])]
    public function edit(article $article, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFilename')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                $article->setImageFileName($newFilename);
            }

            $em->flush();
            $this->addFlash('success', 'Votre article a bien été modifié !');
            return $this->redirectToRoute('article.index');
        }
        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form
        ]);
    }

    #[Route('/admin/articles/create', name: 'article.create')]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAtValue();  // Automatically sets the createdAt value
            $article->setUpdatedAtValue();  // Automatically sets the updatedAt value

            // Handle the image file upload
            $imageFile = $form->get('imageFilename')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $article->setImageFilename($newFilename);
            }

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article.all');
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/admin/articles/{id}/delete', name: 'article.delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, EntityManagerInterface $em, ArticleRepository $articleRepository, $id): Response
    {
        $article = $articleRepository->find($id);

        $em->remove($article);
        $em->flush();
        $this->addFlash('success', 'L\'article a bien été supprimé');
        return $this->redirectToRoute('article.index');
    }

    #[Route('/articles', name: 'article.all')]
    public function indexall(ArticleRepository $repository): Response
    {
        $articles = $repository->findAll();
        return $this->render('article/indexall.html.twig', compact('articles'));
    }

    #[Route('/articles/{id}', name: 'article_show_front')]
    public function showFront(Article $article): Response
    {
        return $this->render('article/show.front.html.twig', [
            'article' => $article,
        ]);
    }
}
