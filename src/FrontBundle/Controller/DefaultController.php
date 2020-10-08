<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Form\ContactType;

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
            'homeMenuClass'  => true,
        );

        return $this->render('FrontBundle:Default:index.html.twig', $renderData);
    }

    public function contactUsAction(Request $request)
    {
    	$productManager = $this->get('utils.product.manager');
        $globalManager  = $this->get('utils.global.manager');
    	$megaMenu       = $globalManager->getMegamenu();
    	$categories     = $globalManager->getAllCategories();
        $bestSellers    = $productManager->getProductsBestSeller();

        $form = $this->createForm(new ContactType(), array(), array(
            'action' => $this->generateUrl('front_contact_us'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $frmData     = $request->get('contact');
            $emailData   = array(
                'from'  => $frmData['contact_email'],
                'name'  => $frmData['contact_name'],
                'phone' => $frmData['contact_phone'],
                'note'  => $frmData['contact_note'],
            );

            $emailManager = $this->get('utils.email.manager');
            $mail = $emailManager->sendMail($emailData);

            return $this->redirectToRoute('front_contact_success', array());
        }

        $renderData     = array(
            'body_id'     => 'contact-us',
            'body_class'  => 'template-page',
            'megaMenu'    => $megaMenu,
            'categories'  => $categories,
            'bestSellers' => $bestSellers,
            'form'        => $form->createView(),
        );

        return $this->render('FrontBundle:Default:contact_us.html.twig', $renderData);
    }

    public function contactSuccessAction()
    {
        return $this->render('FrontBundle:Default:contact_success.html.twig', array());
    }

    public function deliveryAction(Request $request)
    {
        $productManager = $this->get('utils.product.manager');
        $globalManager  = $this->get('utils.global.manager');
        $megaMenu       = $globalManager->getMegamenu();
        $categories     = $globalManager->getAllCategories();
        $bestSellers    = $productManager->getProductsBestSeller();

        $renderData     = array(
            'body_id'     => 'delivery',
            'body_class'  => 'template-page',
            'megaMenu'    => $megaMenu,
            'categories'  => $categories,
            'bestSellers' => $bestSellers,
        );

        return $this->render('FrontBundle:Default:delivery.html.twig', $renderData);
    }
}
