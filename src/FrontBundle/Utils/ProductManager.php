<?php

namespace FrontBundle\Utils;

use Doctrine\ORM\EntityManager;
use AppBundle\Helpers\StringHelper;

class ProductManager
{
    protected $em;
    protected $container;
    protected $productRepo;
    protected $categoryRepo;

    public function __construct(EntityManager $em, $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->productRepo = $em->getRepository('AppBundle:Product');
        $this->categoryRepo = $em->getRepository('AppBundle:Category');
    }

    /**
     *
     * Get product list
     *
     * @param  array $params  Custom parameters
     * @return array $results List of product
     */
    public function getProducts($params = array())
    {
        $results = array();
        $recordsPerPage = $this->container->getParameter('items_per_page');
        
        $params['limit'] = isset($params['limit']) ? $params['limit'] : $recordsPerPage;
        $products = $this->productRepo->findAllProducts($params);

        if ($products) {
            foreach ($products as $item) {
                $images = $this->getProductImages($item['id']);
                $results[] = array(
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => StringHelper::currency($item['price']),
                    'specPrice' => StringHelper::currency($item['specPrice']),
                    'slug' => $item['slug'],
                    'catSlug' => $item['catSlug'],
                    'mainImg' => $images['mainImg'],
                    'thumbImg' => isset($images['thumbImg'][0]) ? $images['thumbImg'][0] : null,
                    'shortdesc' => StringHelper::shortString($item['description']),
                );
            }
        }

        return $results;
    }

    /**
     *
     * Get product detail by id
     *
     * @param  integer $id      Product id
     * @return array   $results Product Informations
     */
    public function getProductById($id)
    {
        return $this->productRepo->find($id);
    }

    /**
     *
     * Get product detail by slug
     *
     * @param  string  $slug    Slug name
     * @return array   $results Product Informations
     */
    public function getProductBySlug($slug)
    {
        $product = $this->productRepo->getProduct($slug);
        if ($product) {
            $product['price'] = StringHelper::currency($product['price']);
            $product['specPrice'] = StringHelper::currency($product['specPrice']);
            $images = $this->getProductImages($product['id']);
            $product['mainImg'] = $images['mainImg'];
            $product['thumbImg'] = $images['thumbImg'];

        }

        return $product;
    }

    public function getProductImages($productId)
    {
        $result = array();
        $imagePath = $this->container->getParameter('front_product_image_path');
        $images = $this->productRepo->getProductImages($productId);

        if ($images) {
            foreach ($images as $image) {
                if ($image['isMain']) {
                    $result['mainImg'] = $imagePath . $image['image'];
                } else {
                    $result['thumbImg'][] = $imagePath . $image['image'];
                }
                
            }
        }

        return $result;
    }

    /**
     *
     * Get all categories
     *
     * @param  array $params  Custom parameters
     * @return array $results List of category
     */
    public function getAllCategories($params = array())
    {
        $results = array();
        $recordsPerPage = $this->container->getParameter('items_per_page');
        
        $params['limit'] = isset($params['limit']) ? $params['limit'] : $recordsPerPage;
        return $this->categoryRepo->findAllCategories($params);
    }
}
