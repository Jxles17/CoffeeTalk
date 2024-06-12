<?php

// src/Controller/EventController.php
namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use DateTime;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class EventController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/events', name: 'event.index')]
    public function index(EventRepository $repository): Response
    {
        $events = $repository->findAll();
        return $this->render('event/index.html.twig', compact('events'));
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/events/{id}', name: 'event.show', requirements: ['id' => '\d+'])]
    public function show(Request $request, int $id, EventRepository $repository): Response
    {
        $event = $repository->find($id);
        return $this->render('event/show.html.twig', [
            'event' => $event
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/events/{id}/edit', name: 'event.edit', methods: ['GET', 'POST'])]
    public function edit(Event $event, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(EventType::class, $event);
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

                $event->setImageFileName($newFilename);
            }

            $em->flush();
            $this->addFlash('success', 'Votre event a bien été modifié !');
            return $this->redirectToRoute('event.index');
        }
        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/events/create', name: 'event.create')]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Utiliser la valeur du formulaire directement pour créer un objet DateTime
            $eventDateTime = $form->get('datetime')->getData();
            $event->setDatetime($eventDateTime);

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFilename')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si quelque chose se produit lors du téléchargement du fichier
                }

                $event->setImageFilename($newFilename);
            }

            $em->persist($event);
            $em->flush();
            $this->addFlash('success', 'Votre événement a bien été ajouté !');
            return $this->redirectToRoute('event.index');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form,
        ]);
    }
    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/events/{id}/delete', name: 'event.delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, EntityManagerInterface $em, EventRepository $eventRepository, $id): Response
    {
        $event = $eventRepository->find($id);

        $em->remove($event);
        $em->flush();
        $this->addFlash('success', 'Le event a bien été supprimé');
        return $this->redirectToRoute('event.index');
    }

    
    #[Route('/events', name: 'event.all')]
    public function indexall(EventRepository $repository): Response
    {
        $events = $repository->findAll();
        return $this->render('event/indexall.html.twig', compact('events'));
    }

    #[Route('/events/{id}', name: 'event_show_front')]
    public function showFront(Event $event): Response
    {
        return $this->render('event/show.front.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/events/inscription/{id}', name: 'event_register', requirements: ['id' => '\d+'])]
    public function inscription(int $id, EventRepository $eventRepository): Response
    {
        // Récupérer l'entité Event par son ID
        $event = $eventRepository->find($id);

        // Si l'événement n'existe pas, lancer une exception 404
        if (!$event) {
            throw $this->createNotFoundException('No event found for id ' . $id);
        }

        // Rendre le template avec les données de l'événement
        return $this->render('event/inscription.html.twig', [
            'event' => $event,
        ]);
    }
}
