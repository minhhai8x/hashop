<?php

namespace FrontBundle\Utils;

use Doctrine\ORM\EntityManager;
use AppBundle\Helpers\StringHelper;

class GlobalManager
{
    protected $em;
    protected $container;
    protected $productRepo;
    protected $categoryRepo;
    protected $configRepo;
    protected $productManager;

    public function __construct(EntityManager $em, $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->productRepo = $em->getRepository('AppBundle:Product');
        $this->categoryRepo = $em->getRepository('AppBundle:Category');
        $this->configRepo = $em->getRepository('AppBundle:Configuration');
        $this->productManager = new ProductManager($em, $container);
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
        return $this->categoryRepo->findAllCategoriesLevel1($params);
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
        $recordsPerPage  = $this->container->getParameter('items_per_page');
        $params['limit'] = isset($params['limit']) ? $params['limit'] : $recordsPerPage;
        $categories = $this->categoryRepo->findAllCategoriesLevel1($params);
        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $result[$key]['info'] = array(
                    'name' => $category->getName(),
                    'pid'  => $category->getParentId() ? $category->getParentId()->getId() : null,
                    'slug' => $category->getSlug(),
                    'subData' => $this->getSubCategoryById($category->getId()),
                );

                // $result[$key]['products'] = array();
                // $products = $this->productManager->getProducts(array('catSlug' => $category->getSlug()));
                // if (!empty($products)) {
                //     $result[$key]['products'] = $products;
                // }
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
     * Get Category by slug
     *
     * @param  string  $slug
     * @return Category|null $category
     */
    public function getCategoryBySlug($slug)
    {
        return $this->categoryRepo->findOneBySlug($slug);
    }

    /**
     *
     * Get Sub Category by Id
     *
     * @param  integer  $categoryId
     * @return array
     */
    public function getSubCategoryById($categoryId)
    {
        return  $this->categoryRepo->getSubCategoriesById($categoryId);
    }
}
