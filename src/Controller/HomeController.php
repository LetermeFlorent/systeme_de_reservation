<?php
// src/Controller/HomeController.php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\ActivityRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\LevelRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ActivityRepository $activityRepository, ReservationRepository $reservationRepository): Response
    {
        // Récupère toutes les activités avec leurs sessions et niveaux
        $activities = $activityRepository->findAllActivitiesWithSessionsAndLevels();

        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        // Récupère toutes les réservations de l'utilisateur connecté
        $userReservations = $user ? $reservationRepository->findBy([
            'user_name' => $user->getUserIdentifier(),
        ]) : [];

        // Crée un tableau des noms des activités réservées
        $reservedActivityNames = array_map(fn($reservation) => $reservation->getName(), $userReservations);

        // Ajoute l'état d'inscription pour chaque activité
        $activitiesWithRegistrationStatus = array_map(function ($activity) use ($reservedActivityNames) {
            return [
                'activity_id' => $activity['activity_id'],
                'activity_name' => $activity['activity_name'],
                'session_id' => $activity['session_id'], // Ajout de cette ligne
                'session_date' => $activity['session_date'],
                'level_label' => $activity['level_label'],
                'session_time' => $activity['session_time'],
                'session_duration' => $activity['session_duration'],
                'is_registered' => in_array($activity['activity_name'], $reservedActivityNames, true),
            ];
        }, $activities);

        return $this->render('home/index.html.twig', [
            'activities' => $activitiesWithRegistrationStatus,
        ]);
    }


    #[Route('/reserve', name: 'app_reserve', methods: ['POST'])]
    public function reserve(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();

        if (!$user) {
            return new Response('Vous devez être connecté pour réserver.', 401);
        }

        if ($reservationRepository->findOneBy([
            'name' => $data['name'],
            'date' => $data['date'],
            'user_name' => $user->getUserIdentifier()
        ])) {
            return new Response('Vous êtes déjà inscrit à cette activité.', 400);
        }

        $reservation = new Reservation();
        $reservation->setName($data['name']);
        $reservation->setDate($data['date']);
        $reservation->setUserName($user->getUserIdentifier());
        $reservation->setReservationDate(new \DateTime($data['reservation_date']));

        $entityManager->persist($reservation);
        $entityManager->flush();

        return new Response('Reservation enregistrée avec succès');
    }

    #[Route('/unreserve', name: 'app_unreserve', methods: ['POST'])]
    public function unreserve(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();

        if (!$user) {
            return new Response('Vous devez être connecté pour vous désinscrire.', 401);
        }

        $reservation = $reservationRepository->findOneBy([
            'name' => $data['name'],
            'date' => $data['date'],
            'user_name' => $user->getUserIdentifier()
        ]);

        if ($reservation) {
            $entityManager->remove($reservation);
            $entityManager->flush();
            return new Response('Désinscription effectuée avec succès');
        }

        return new Response('Aucune réservation trouvée', 404);
    }

    #[Route('/admin', name: 'app_admin_home')]
    public function adminHome(ActivityRepository $activityRepository, LevelRepository $levelRepository): Response
    {
        // Récupère toutes les activités avec leurs sessions et niveaux
        $activities = $activityRepository->findAllActivitiesWithSessionsAndLevels();
    
        // Récupère tous les niveaux
        $levels = $levelRepository->findAll();
    
        return $this->render('home/admin_home.html.twig', [
            'activities' => $activities,
            'levels' => $levels, // Passer les niveaux au template
        ]);
    }

}