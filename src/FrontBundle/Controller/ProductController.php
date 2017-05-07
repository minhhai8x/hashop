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
            'amount' => 100,
            'body_id' => $slug,
            'body_class' => 'template-product',
            'product' => array(),
            'categories' => $categories,
        );

        if ($product) {
            $renderData['product'] = $product;
        }

        return $this->render('FrontBundle:Product:detail.html.twig', $renderData);
    }
    
    public function categoryAction($slug)
    {
        var_dump($slug);die;
    }
}
