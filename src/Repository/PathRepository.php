<?php

namespace App\Repository;

use App\Entity\Path;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Path|null find($id, $lockMode = null, $lockVersion = null)
 * @method Path|null findOneBy(array $criteria, array $orderBy = null)
 * @method Path[]    findAll()
 * @method Path[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PathRepository extends ServiceEntityRepository {

    private $security;

    public function __construct(ManagerRegistry $registry, Security $security) {
        parent::__construct($registry, Path::class);
        $this->security = $security;
    }

    public function findForSearch(Path $path) {
        $user = $this->security->getUser();

        $query = $this->createQueryBuilder('p')
                ->where('1 = 1')
        ;

        if (!is_null($user)) {
            $query->andWhere('p.driver != :user');
            $query->setParameter(':user', $user);
        }

        $query->andWhere('p.leftSeats >= :leftSeats');
        $query->setParameter(':leftSeats', $path->getLeftSeats());
        $query->andWhere('p.leftSeats > 0');
        
        $query->andWhere('p.startTime >= :startTime');
        $query->setParameter(':startTime', $path->getStartTime());


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
