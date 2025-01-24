<?php
// src/Repository/ActivityRepository.php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Activity>
 */
class ActivityRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Activity::class);
        $this->entityManager = $entityManager;
    }

    /* Récupère toutes les activités avec leurs sessions et niveaux, sans les dates.*/
    public function findAllActivitiesWithSessionsAndLevels(): array
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.sessions', 's')
            ->join('a.level', 'l')
            ->select(
                'a.id AS activity_id',
                'a.label AS activity_name',
                'l.label AS level_label',
                's.id AS session_id',
                's.date AS session_date',
                's.heure AS session_time',
                's.duration AS session_duration'
            )
            ->orderBy('s.date', 'ASC')
            ->addOrderBy('a.label', 'ASC');

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function deleteActivityWithSessions(int $activityId): void
    {
        $activity = $this->find($activityId);

        if ($activity) {
            foreach ($activity->getSessions() as $session) {
                $this->entityManager->remove($session);
            }
            $this->entityManager->remove($activity);
            $this->entityManager->flush();
        }
    }
}
