<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ProduitController extends AbstractController
{
    #[Route('/admin/produits', name: 'produit.index')]
    public function index(ProduitRepository $repository): Response
    {   

        // $this->denyAccessUnlessGranted('ROLE_USER');

        $produits = $repository->findAll();

        return $this->render('produit/index.html.twig', compact('produits'));
    }


    #[Route('/admin/produits/{id}', name: 'produit.show', requirements: ['id' => '\d+'])] 
    public function show (Request $request, int $id, ProduitRepository $repository): Response
    {
        $produit = $repository->find($id);


        return $this->render('produit/show.html.twig', [
            'produit' => $produit
        ]);
    }



    #[Route('/admin/produits/{id}/edit', name: 'produit.edit', methods:['GET', 'POST'])]
    public function edit(Produit $produit, Request $request, EntityManagerInterface $em)
    {   
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Votre produit a bien été modifié !');
            return $this->redirectToRoute('produit.index');
        }
        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form
        ]);
    }

    #[Route('/admin/produits/create', name: 'produit.create')]
    public function create(Request $request, EntityManagerInterface $em){

        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success', 'Votre produit a bien été ajouté !');
            return $this->redirectToRoute('produit.index');
        }
        return $this->render('produit/create.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/admin/produits/{id}/delete', name: 'produit.delete', methods:['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, EntityManagerInterface $em, ProduitRepository $produitRepository, $id){

        $produit = $produitRepository->find($id);

        $em->remove($produit);
        $em->flush();
        $this->addFlash('success', 'Le produit a bien été supprimé');
        return $this->redirectToRoute('produit.index');
    }

    
}
