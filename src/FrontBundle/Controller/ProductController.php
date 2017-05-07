<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function detailAction($category, $slug)
    {
        $productManager = $this->get('utils.product.manager');
        $product = $productManager->getProductBySlug($slug);
        $categories = $productManager->getAllCategories();

        $renderData = array(
            'body_id' => $slug,
            'body_class' => 'template-product',
            'product' => array(),
            'categories' => $categories,
            'amount' => 0,
        );

        if ($product) {
            $renderData['product'] = $product;
        }

        return $this->render('FrontBundle:Product:detail.html.twig', $renderData);
    }
    
    public function categoryAction($slug)
    {
        $productManager = $this->get('utils.product.manager');
        $category       = $productManager->getCategoryBySlug($slug);
        $categories     = $productManager->getAllCategories();
        $products       = $productManager->getProductByCategory(array('catSlug' => $slug));
        $megaMenu       = $productManager->getMegamenu();

        $renderData = array(
            'body_id'    => $slug,
            'body_class' => 'template-collection',
            'categories' => $categories,
            'products'   => $products,
            'megaMenu'   => $megaMenu,
        );

        if ($category) {
            $renderData['category'] = $category;
        }

        return $this->render('FrontBundle:Category:index.html.twig', $renderData);
    }
}
