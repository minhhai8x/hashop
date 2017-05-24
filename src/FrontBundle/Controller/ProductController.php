<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function detailAction($category, $slug)
    {

        $globalManager   = $this->get('utils.global.manager');
        $categories      = $globalManager->getAllCategories();
        $megaMenu        = $globalManager->getMegamenu();

        $productManager  = $this->get('utils.product.manager');
        $product         = $productManager->getProductBySlug($slug);
        $productsRelated = $productManager->getProductsRelated($product['id'], $product['catId']);
        $bestSellers     = $productManager->getProductsBestSeller();

        $renderData = array(
            'body_id'    => $slug,
            'body_class' => 'template-product',
            'product'    => array(),
            'categories' => $categories,
            'megaMenu'   => $megaMenu,
            'amount'     => 0,
            'productsRelated' => $productsRelated,
            'bestSellers'  => $bestSellers,
        );

        if ($product) {
            $renderData['product'] = $product;
        }

        return $this->render('FrontBundle:Product:detail.html.twig', $renderData);
    }

    public function categoryAction($slug, $page)
    {
        $globalManager  = $this->get('utils.global.manager');
        $categories     = $globalManager->getAllCategories();
        $megaMenu       = $globalManager->getMegamenu();

        $productManager = $this->get('utils.product.manager');
        $category       = $productManager->getCategoryBySlug($slug);
        $bestSellers    = $productManager->getProductsBestSeller();
        $products       = $productManager->getProductByCategory(array(
            'catSlug' => $slug,
            'page'    => (int) $page,
         ));

        $renderData = array(
            'body_id'    => $slug,
            'body_class' => 'template-collection',
            'categories' => $categories,
            'products'   => $products['data'],
            'megaMenu'   => $megaMenu,
            'bestSellers' => $bestSellers,
        );

        if ($category) {
            $renderData['category'] = $category;

            if ($products['total'] > 0) {
                $totalPage = ceil($products['total']/$products['limit']);
                $renderData['paginator'] = $this->renderView('FrontBundle:Default:pagination.html.twig', array(
                    'totalPage'   => $totalPage,
                    'currentPage' => (int) $page,
                    'categorySlug'    => $category['slug']
                ));
            }
        }

        return $this->render('FrontBundle:Category:index.html.twig', $renderData);
    }
}
