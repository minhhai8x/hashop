<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FrontBundle\Form\BuyCartType;
use FrontBundle\Form\OrderType;

class CartController extends Controller
{
    public function indexAction(Request $request)
    {
        $cartManager = $this->get('utils.cart.manager');

        if ($request->get("buy_cart")) {
            $cartManager->addItem($request->get("buy_cart"));
        }

        $form = $this->createForm(new BuyCartType(), array(), array(
            'action' => $this->generateUrl('front_cart'),
            'method' => 'POST',
        ));

        $globalManager  = $this->get('utils.global.manager');

        $productManager = $this->get('utils.product.manager');
        $categories     = $globalManager->getAllCategories();

        $megaMenu     = $globalManager->getMegamenu();
        $bestSellers  = $productManager->getProductsBestSeller();

        $renderData = array(
            'body_id'     => 'shopping-cart',
            'body_class'  => 'template-cart',
            'megaMenu'    => $megaMenu,
            'bestSellers' => $bestSellers,
            'categories'  => $categories,
            'cartData'    => $cartManager->getCart(),
            'form'        => $form->createView()
        );

        return $this->render('FrontBundle:Cart:index.html.twig', $renderData);
    }

    public function updateAction(Request $request)
    {
        if ($request->get('id') && $request->get('qty')) {
            $productId = (int) $request->get('id');
            $quantity = (int) $request->get('qty');
            $cartManager = $this->get('utils.cart.manager');
            $cartManager->updateItem(array(
                'hidden_id' => $productId,
                'quantity'  => $quantity,
            ));

        }

        return new JsonResponse(array('success' => true));
    }

    public function removeItemAction(Request $request)
    {
        if ($request->get('id')) {
            $productId   = (int) $request->get('id');
            $cartManager = $this->get('utils.cart.manager');
            $cartManager->removeItem($productId);
        }

        return new JsonResponse(array('success' => true));
    }

    public function checkoutAction(Request $request)
    {
        $globalManager  = $this->get('utils.global.manager');
        $productManager = $this->get('utils.product.manager');
        $megaMenu       = $globalManager->getMegamenu();
        $categories     = $globalManager->getAllCategories();
        $bestSellers    = $productManager->getProductsBestSeller();

        $form = $this->createForm(new OrderType(), array(), array(
            'action' => $this->generateUrl('front_cart_checkout'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $frmData     = $request->get('order');
            $cartManager = $this->get('utils.cart.manager');
            $newOrder    = $cartManager->createNewOrder($frmData);

            return $this->redirectToRoute('front_cart_success', array('orderNo' => $newOrder->getOrderNo()));
        }

        $renderData = array(
            'megaMenu'    => $megaMenu,
            'bestSellers' => $bestSellers,
            'categories'  => $categories,
            'form'        => $form->createView(),
        );

        return $this->render('FrontBundle:Cart:checkout.html.twig', $renderData);
    }

    public function successAction(Request $request)
    {
        $globalManager  = $this->get('utils.global.manager');
        $productManager = $this->get('utils.product.manager');
        $megaMenu       = $globalManager->getMegamenu();
        $categories     = $globalManager->getAllCategories();
        $bestSellers    = $productManager->getProductsBestSeller();

        $renderData = array(
            'megaMenu'    => $megaMenu,
            'bestSellers' => $bestSellers,
            'categories'  => $categories,
            'orderNo'     => $request->get('orderNo'),
        );

        return $this->render('FrontBundle:Cart:success.html.twig', $renderData);
    }
}
