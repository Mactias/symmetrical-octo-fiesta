<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findBySomeField($field, $value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere("lower(b.$field) LIKE :val")
            ->setParameter('val', "%$value%")
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAllFields($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('lower(b.author) LIKE :val OR lower(b.title) LIKE :val OR lower(b.subject) LIKE :val OR lower(b.publisher) LIKE :val OR lower(b.isbn) LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function advancedFieldsSearch($values)
    {
        $val = $values['search1'];

        $qb = $this->createQueryBuilder('b')
            ->where("lower(b.{$values['findby1']}) LIKE :val")
            ->setParameter('val', "%$val%")
            ->orderBy('b.title', 'ASC');

        $val = $values['search2'];
        $logic1 = $values['logic1'];
        $findby = $values['findby2'];

        if ($val && ($logic1 === 'LIKE' || $logic1 === 'NOT LIKE')) {
            $qb->andWhere("lower(b.$findby) $logic1 :val2")
                ->setParameter('val2', "%$val%");
        } elseif ($val && $logic1 === 'OR') {
            $qb->orWhere("lower(b.$findby) LIKE :val2")
                ->setParameter('val2', "%$val%");
        }

        $val = $values['search3'];
        $logic = $values['logic2'];
        $findby = $values['findby3'];

        if ($val && ($logic === 'LIKE' || $logic === 'NOT LIKE')) {
            $qb->andWhere("lower(b.$findby) $logic :val3")
                ->setParameter('val3', "%$val%");
        } elseif ($val && $logic === 'OR') {
            $qb->orWhere("lower(b.$findby) LIKE :val3")
                ->setParameter('val3', "%$val%");
        }

        $val = $values['search4'];
        $logic = $values['logic3'];
        $findby = $values['findby4'];

        if ($val && ($logic === 'LIKE' || $logic === 'NOT LIKE')) {
            $qb->andWhere("lower(b.$findby) $logic :val4")
                ->setParameter('val4', "%$val%");
        } elseif ($val && $logic === 'OR') {
            $qb->orWhere("lower(b.$findby) LIKE :val4")
                ->setParameter('val4', "%$val%");
        }

        return $qb->getQuery()->getResult();
    }
}
