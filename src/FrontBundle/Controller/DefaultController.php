<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $globalManager  = $this->get('utils.global.manager');
        $productManager = $this->get('utils.product.manager');
        $bannerManager  = $this->get('utils.banner.manager');

        $banners      = $bannerManager->getAllBanners();
        $megaMenu     = $globalManager->getMegamenu();
        $homeProducts = $productManager->getProducts();
        $bestSellers  = $productManager->getProductsBestSeller();

        $renderData = array(
            'products' => $homeProducts,
            'megaMenu' => $megaMenu,
            'banners'  => $banners,
            'bestSellers'  => $bestSellers,
        );

        return $this->render('FrontBundle:Default:index.html.twig', $renderData);
    }

    public function contactUsAction()
    {
    	$productManager = $this->get('utils.product.manager');
        $globalManager  = $this->get('utils.global.manager');
    	$megaMenu       = $globalManager->getMegamenu();
    	$categories     = $globalManager->getAllCategories();
        $bestSellers    = $productManager->getProductsBestSeller();
        $renderData     = array(
            'body_id' => 'contact-us',
            'body_class' => 'template-page',
            'megaMenu'   => $megaMenu,
            'categories' => $categories,
            'bestSellers'  => $bestSellers,
        );

        return $this->render('FrontBundle:Default:contact_us.html.twig', $renderData);
    }
}
