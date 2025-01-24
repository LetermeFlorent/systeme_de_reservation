<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Session;

#[Route('/activity')]
final class ActivityController extends AbstractController
{
    #[Route(name: 'app_activity_index', methods: ['GET'])]
    public function index(ActivityRepository $activityRepository): Response
    {
        return $this->render('activity/index.html.twig', [
            'activities' => $activityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_activity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données du formulaire
            $date = $form->get('date')->getData();
            $heure = $form->get('heure')->getData();
            $durationHours = $form->get('duration_hours')->getData();
            $durationMinutes = $form->get('duration_minutes')->getData();
    
            // Crée une nouvelle session
            $session = new Session();
            $session->setDate($date);
            $session->setHeure($heure);
    
            // Convertit la durée en objet DateTime
            $duration = new \DateTime();
            $duration->setTime($durationHours, $durationMinutes);
            $session->setDuration($duration);
    
            // Lie la session à l'activité
            $session->setActivity($activity);
    
            // Enregistre l'activité et la session en base de données
            $entityManager->persist($activity);
            $entityManager->persist($session);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activity_show', methods: ['GET'])]
    public function show(Activity $activity): Response
    {
        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activity $activity, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activity_delete', methods: ['DELETE'])]
    public function delete(Request $request, Activity $activity, EntityManagerInterface $entityManager): Response
    {
        // Vérifie le token CSRF pour la sécurité
        if ($this->isCsrfTokenValid('delete' . $activity->getId(), $request->request->get('_token'))) {
            // Supprime l'activité (la session associée sera supprimée automatiquement)
            $entityManager->remove($activity);
            $entityManager->flush();
        }
    
        // Redirige vers la liste des activités
        return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
    }
    
    

}
