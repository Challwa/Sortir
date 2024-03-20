<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findAllWithEtat()
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.etats', 'e')
            ->addSelect('e')
            ->getQuery()
            ->getResult();
    }

    public function filter(array $searchData): array
    {
        $queryBuilder = $this->createQueryBuilder('s');

        if ($searchData['nom']) {
            $queryBuilder->andWhere('s.nom LIKE :nom')
                ->setParameter('nom', '%' . $searchData['nom'] . '%');
        }

        if ($searchData['sites']) {
            $queryBuilder->leftJoin('s.sites', 'sites')
                ->andWhere('sites.nom LIKE :site')
                ->setParameter('site', '%' . $searchData['sites']->getNom() . '%');
        }

        if($searchData['startDate']){

            $startDate = new \DateTime($searchData['startDate']->format('d-m-Y') . '00:00:00');
            $queryBuilder->andWhere('s.dateHeureDebut >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        if($searchData['endDate']){
            $endDate = new \DateTime($searchData['endDate']->format('d-m-Y') . '23:59:59');
            $queryBuilder->andWhere('s.dateLimiteInscription <= :endDate')
                ->setParameter('endDate', $endDate);
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
