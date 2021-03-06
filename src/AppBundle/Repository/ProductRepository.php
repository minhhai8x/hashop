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
                    ->where('p.isShowed = 1')
                    ->leftJoin('p.category', 'cat')
                    ->orderBy('p.updatedAt', 'DESC');

        if (isset($params['catSlug'])) {
            $query = $query->andWhere('cat.slug  = :catSlug')
                           ->setParameter('catSlug', $params['catSlug']);
        }

        $query = $query->setMaxResults($params['limit'])->getQuery();
        $results = $query->getResult();

        return $results;
    }

    public function getProduct($slug)
    {
        $query   = $this->createQueryBuilder('p')
                    ->select('p.id, p.name, p.slug, p.description, p.price, p.specPrice, cat.name as catName, cat.slug as catSlug, cat.id as catId')
                    ->leftJoin('p.category', 'cat')
                    ->where('p.isShowed = 1')
                    ->andWhere('p.slug = :slug')
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

    public function getProductsRelated($productId, $categoryId)
    {
        $query   = $this->createQueryBuilder('p')
                    ->select('p.id, p.name, p.slug, p.description, p.price, p.specPrice, cat.name as catName, cat.slug as catSlug')
                    ->join('p.category', 'cat')
                    ->where('p.id != :pId')
                    ->andWhere('cat.id = :catId')
                    ->andWhere('p.isShowed = 1')
                    ->setParameters(array('pId' => $productId, 'catId' => $categoryId))
                    ->orderBy('p.updatedAt', 'DESC')
                    ->getQuery();

        $results = $query->getResult();
        return $results;
    }

    public function getAllProducts($params)
    {
        $query    = $this->createQueryBuilder('p')
                    ->select("p.id, cat.id as catId, cat.name as catName, cat.slug as catSlug, p.slug as slug, p.name, p.description, p.price, p.specPrice")
                    ->where('p.isShowed = 1')
                    ->leftJoin('p.category', 'cat')
                    ->orderBy('p.updatedAt', 'DESC');

        if (isset($params['catSlug'])) {
            $query = $query->andWhere('cat.slug  = :catSlug')
                           ->setParameter('catSlug', $params['catSlug']);
        }

        $clQuery = clone($query);
        $total   = count($clQuery->getQuery()->getResult());

        $query = $query->setFirstResult($params['offset'])
                       ->setMaxResults($params['limit'])
                       ->getQuery();
        $results = $query->getResult();

        return array(
            'data'  => $results,
            'total' => $total,
        );
    }

    public function getProductsBestSeller()
    {
        $query   = $this->createQueryBuilder('p')
                    ->select("p.id, cat.id as catId, cat.name as catName, cat.slug as catSlug, p.slug as slug, p.name, p.description, p.price, p.specPrice")
                    ->where('p.isBestSeller = 1')
                    ->leftJoin('p.category', 'cat')
                    ->orderBy('p.updatedAt', 'DESC')
                    ->getQuery();

        $results = $query->getResult();
        return $results;
    }
}
