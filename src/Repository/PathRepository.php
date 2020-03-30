<?php

namespace App\Repository;

use App\Entity\Path;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Path|null find($id, $lockMode = null, $lockVersion = null)
 * @method Path|null findOneBy(array $criteria, array $orderBy = null)
 * @method Path[]    findAll()
 * @method Path[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PathRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Path::class);
    }

    public function findForSearch(Path $path) {
        $query = $this->createQueryBuilder('p')
                ->where('1 = 1')
        ;

        if (!is_null($path->getSeats()) && $path->getSeats() > 0){
            $query->andWhere('p.seats >= :seats');
            $query->setParameter(':seats', $path->getSeats());
        }
        
        if (!is_null($path->getStartTime()) && $path->getStartTime() != "") {
            $query->andWhere('p.startTime >= :startTime');
            $query->setParameter(':startTime', $path->getStartTime());
        }
        
        if (!is_null($path->getStartLocation()) && $path->getStartLocation() != "") {
            $query->andWhere('p.startLocation = :startLocation');
            $query->setParameter(':startLocation', $path->getStartLocation());
        }
        
        if (!is_null($path->getEndLocation()) && $path->getEndLocation() != "") {
            $query->andWhere('p.endLocation = :endLocation');
            $query->setParameter(':endLocation', $path->getEndLocation());
        }
        
        $query->orderBy('p.startTime', 'ASC');
        
        return $query->getQuery()->getResult();
    }

}
