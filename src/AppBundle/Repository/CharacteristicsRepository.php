<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class CharacteristicsRepository extends EntityRepository
{
    /**
     * Gets all existing categories for provided age and gender.
     *
     * @param string $gender
     * @param string $age
     * @return array
     */
    public function getAllCategories($gender, $age)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->select('c.category')
            ->innerJoin('c.product', 'p')
            ->where('c.gender = :gender')
            ->setParameter('gender', $gender)
            ->andWhere('c.age = :age')
            ->setParameter('age', $age)
            ->groupBy('c.category');

        return $qb->getQuery()->getArrayResult();
    }

    public function getAllColors($gender, $age, $category)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->select('DISTINCT LOWER(c.color) AS color')
            ->innerJoin('c.product', 'p')
            ->where('c.gender = :gender')
            ->setParameter('gender', $gender)
            ->andWhere('c.age = :age')
            ->setParameter('age', $age)
            ->andWhere('c.category = :category')
            ->setParameter('category', $category);

        return $qb->getQuery()->getArrayResult();
    }
    
    public function getCharacteristicsByFilter($filters)
    {

        $sql = 'SELECT c
            FROM AppBundle:Characteristics c 
            INNER JOIN c.product p 
            INNER JOIN p.store s
            WHERE c.age = :age
            AND c.gender = :gender
            AND c.category = :category
            AND (';

        foreach ($filters['color'] as $color) {
            $sql .= "LOWER(c.color) LIKE '%" . strtolower($color) . "%' OR ";
        }
        $sql = substr($sql, 0, -3);
        $sql .= ') ';


        if (intval($filters['store']) !== 0) {
            $sql .= 'AND s.id = ' . intval($filters['store']) . ' ';
        }

        if (!is_null($filters['price'])) {
            switch (intval($filters['price'])) {
                case 1:
                    $sql .= 'AND p.price < ' . 100 . ' ';
                    break;
                case 2:
                    $sql .= 'AND p.price < ' . 200 . ' ';
                    break;
                case 3:
                    $sql .= 'AND p.price < ' . floatval($filters['maxPrice']) . ' ';
                    break;
                default:
                    break;
            }
        }

        switch ($filters['sort']) {
            case 1:
                $sql .= 'ORDER BY p.price ASC';
                break;
            case 2:
                $sql .= 'ORDER BY p.price DESC';
                break;
            default:
                $sql .= 'ORDER BY p.name ASC';
                break;
        }

        $qb = $this->getEntityManager()->createQuery($sql);
        $qb->setParameter('age', $filters['age'])
            ->setParameter('gender', $filters['gender'])
            ->setParameter('category', $filters['category']);

        return $qb->getResult();
    }

    public function checkIfColorHasProducts($gender, $age, $category, $color)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->select('count(c.color)')
            ->innerJoin('c.product', 'p')
            ->where('c.gender = :gender')
            ->setParameter('gender', $gender)
            ->andWhere('c.age = :age')
            ->setParameter('age', $age)
            ->andWhere('c.category = :category')
            ->setParameter('category', $category)
            ->andWhere('LOWER(c.color) LIKE :color')
            ->setParameter('color', '%' . $color . '%');

        return $qb->getQuery()->getOneOrNullResult();
    }
}
