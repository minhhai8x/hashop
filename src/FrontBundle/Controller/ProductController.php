<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function detailAction($slug)
    {
        $productImagePath = $this->getParameter('product_image_path');
        $productManager = $this->container->get('utils.product.manager');
        $product = $productManager->getProductBySlug($slug);

        $renderData = array(
            'amount' => 100,
            'body_id' => $slug,
            'body_class' => 'template-product',
            'product' => array(),  
        );

        if ($product) {
            $renderData['product'] = $product;
            $productImage = $productImagePath . $product['image'];
            $renderData['product_image'] = $productImage;
        }

        return $this->render('FrontBundle:Product:detail.html.twig', $renderData);
    }

}
