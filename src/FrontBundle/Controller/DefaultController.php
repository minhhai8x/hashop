<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $productManager = $this->get('utils.product.manager');
        $megaMenu       = $productManager->getMegamenu();
        $homeProducts = $productManager->getProducts();
        $renderData = array(
            'products' => $homeProducts,
            'megaMenu'   => $megaMenu,
        );

        return $this->render('FrontBundle:Default:index.html.twig', $renderData);
    }

    public function contactUsAction()
    {
    	$productManager = $this->get('utils.product.manager');
    	$megaMenu       = $productManager->getMegamenu();
    	$categories     = $productManager->getAllCategories();
        $renderData     = array(
            'body_id' => 'contact-us',
            'body_class' => 'template-page',
            'megaMenu'   => $megaMenu,
            'categories' => $categories,
        );

        return $this->render('FrontBundle:Default:contact_us.html.twig', $renderData); 
    }
}
