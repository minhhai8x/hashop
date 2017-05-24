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
    protected $configRepo;

    public function __construct(EntityManager $em, $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->productRepo = $em->getRepository('AppBundle:Product');
        $this->categoryRepo = $em->getRepository('AppBundle:Category');
        $this->configRepo = $em->getRepository('AppBundle:Configuration');
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
        $imageDefault = $this->container->getParameter('front_product_image_default');
        if ($product) {
            $product['price'] = StringHelper::currency($product['price']);
            $product['specPrice'] = StringHelper::currency($product['specPrice']);
            $images = $this->getProductImages($product['id']);
            $product['mainImg'] = isset($images['mainImg']) ? $images['mainImg'] : $imageDefault;
            $product['thumbImg'] = isset($images['thumbImg']) ? $images['thumbImg'] : array();
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

        if (!isset($result['mainImg'])) {
            $result['mainImg'] = $this->container->getParameter('front_product_image_default');
        }

        return $result;
    }

    /**
     *
     * Get category detail by slug
     *
     * @param  string  $slug    Slug name
     * @return array   $results Category Informations
     */
    public function getCategoryBySlug($slug)
    {
        $category = $this->categoryRepo->getCategory($slug);
        return $category;
    }

    /**
     *
     * Get product by category
     *
     * @param  array $params  Custom parameters
     * @return array $results List of product
     */
    public function getProductByCategory($params = array())
    {
        $results = array('data' => array(), 'total' => 0);
        $recordsPerPage = $this->container->getParameter('items_category_per_page');

        $params['page']   = isset($params['page']) ? $params['page'] : 1;
        $params['limit']  = isset($params['limit']) ? $params['limit'] : $recordsPerPage;
        $params['offset'] = ($params['page'] - 1) * $params['limit'];
        $products = $this->productRepo->getAllProducts($params);

        if (isset($products['data']) && !empty($products['data'])) {
            $results['total'] = $products['total'];
            $results['limit'] = $params['limit'];
            foreach ($products['data'] as $item) {
                $images = $this->getProductImages($item['id']);
                $results['data'][] = array(
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
     * Get product related
     *
     * @param  integer $productId  Product ID
     * @param  integer $categoryId  Category ID
     * @return array $results List of product
     */
    public function getProductsRelated($productId, $categoryId)
    {
        $results = array();
        $recordsPerPage = $this->container->getParameter('items_per_page');
        $products = $this->productRepo->getProductsRelated($productId, $categoryId);

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
     * Get product best seller
     *
     * @return array $results List of product
     */
    public function getProductsBestSeller()
    {
        $results = array();
        $bestSellers  = $this->productRepo->getProductsBestSeller();

        if ($bestSellers) {
            foreach ($bestSellers as $item) {
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
}
