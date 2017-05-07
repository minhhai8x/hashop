<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    public function findAllProducts($params)
    {
        $query    = $this->createQueryBuilder('p')
                    ->select("p.id, cat.id as catId, cat.name as catName, cat.slug as catSlug, p.slug as slug, p.name, p.description, p.price, p.specPrice")
                    ->leftJoin('p.category', 'cat')
                    ->setMaxResults($params['limit'])
                    ->getQuery();

        $results = $query->getResult();
        return $results;
    }

    public function getProduct($slug)
    {
        $query   = $this->createQueryBuilder('p')
                    ->select('p.id, p.name, p.slug, p.description, p.price, p.specPrice, cat.name as catName, cat.slug as catSlug')
                    ->leftJoin('p.category', 'cat')
                    ->where('p.slug = :slug')
                    ->setParameter('slug', $slug)
                    ->getQuery();

        $results = $query->getOneOrNullResult();
        return $results;
    }

    public function getProductImages($productId)
    {
        $query   = $this->createQueryBuilder('p')
                    ->select('img.id, img.name, img.image, img.isMain')
                    ->innerJoin('p.images', 'img')
                    ->where('p.id = :product_id')
                    ->setParameter('product_id', $productId)
                    ->getQuery();

        return $query->getResult();
    }
}
