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
     * Get mega menu
     *
     * @return array $results Megamenu items
     */
    public function getMegamenu()
    {
        $result = array();
        $categories = $this->getAllCategories();
        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $result[$key]['info'] = array(
                    'name' => $category['name'],
                    'slug' => $category['slug'],
                );

                $result[$key]['products'] = array();
                $products = $this->getProducts(array('catSlug' => $category['slug']));
                if (!empty($products)) {
                    $result[$key]['products'] = $products;
                }
            }
        }

        return $result;
    }

    /**
     *
     * Get Global configurations
     *
     * @return array $results Global configurations
     */
    public function getGlobalConfigs()
    {
        return $this->configRepo->getConfigs();
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
}