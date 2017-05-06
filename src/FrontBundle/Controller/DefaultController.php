<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$productManager = $this->get('utils.product.manager');
    	$homeProducts = $productManager->getProducts();
    	$renderData = array(
    		'products' => $homeProducts,
    	);
    	//var_dump($renderData);die;
        return $this->render('FrontBundle:Default:index.html.twig', $renderData);
    }
}
