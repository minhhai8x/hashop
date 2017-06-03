<?php

namespace FrontBundle\Utils;

use AppBundle\Entity\Order;
use AppBundle\Entity\Product;

class CartManager
{
  protected $session;
  protected $productManager;
  protected $container;


  /**
   * Constructs the CartManager instance
   *
   * @param Container $container
   */
  public function __construct($container)
  {
    $this->session = $container->get('session');
    $this->productManager = $container->get('utils.product.manager');
    $this->container = $container;
  }

  public function addItem($itemData)
  {
    $itemId  = $itemData['hidden_id'];
    $product = $this->productManager->getProductById($itemId);
    $cart    = $this->getCart();

    if ($product) {
      $cartData = $product;
      $cartData['price'] = $product['specPrice'] ? $product['specPrice'] : $product['price'];
      $cartData['quantity'] = (int) $itemData['quantity'];
      if (!isset($cart['data'][$itemId]))
      {
        $cart['data'][$itemId] = $cartData;
      } else {
        $cart['data'][$itemId]['quantity'] +=  $cartData['quantity'];
      }

      $cart['data'][$itemId]['subtotal'] = $cart['data'][$itemId]['quantity'] * $cartData['price'];
    }

    $this->session->set('cart', $cart);
  }

  public function updateItem($itemData)
  {
    $itemId  = $itemData['hidden_id'];
    $product = $this->productManager->getProductById($itemId);
    $cart    = $this->getCart();

    if ($product) {
      $cartData['price'] = $product['specPrice'] ? $product['specPrice'] : $product['price'];
      $cart['data'][$itemId]['quantity'] =  (int) $itemData['quantity'];
      $cart['data'][$itemId]['subtotal'] = $cart['data'][$itemId]['quantity'] * $cartData['price'];
    }

    $this->session->set('cart', $cart);
  }

  public function removeItem($id)
  {
    $cart = $this->getCart();

    if (isset($cart['data'][$id]))
    {
      unset($cart['data'][$id]);
    }

    $this->session->set('cart', $cart);
  }

  public function getCart()
  {
    $result = array('data' => array(), 'total' => 0, 'count' => 0);
    $cart = $this->session->get('cart', array());
    if ($cart && $cart['data']) {
      $result['data'] = $cart['data'];
      foreach ($cart['data'] as $item) {
        $result['total'] += $item['subtotal'];
        $result['count']++;
      }

    }

    return $result;
  }

  public function createNewOrder($data)
  {
    $em    = $this->container->get('doctrine.orm.entity_manager');
    $order = new Order();
    $order->setOrderNo(time());
    $order->setCustomerName($data['customer_name']);
    $order->setCustomerEmail($data['customer_email']);
    $order->setCustomerAddress($data['customer_address']);
    $order->setCustomerPhone($data['customer_phone']);

    $cart = $this->session->get('cart', array());
    if ($cart['data']) {
      $productRepo = $em->getRepository('AppBundle:Product');
      foreach ($cart['data'] as $item) {
        $product = $productRepo->find($item['id']);
        $product->addOrder($order);
        $order->addProduct($product);
      }
    }

    $order->setTotal($cart['total']);
    $order->setCustomerNote($data['customer_note']);
    $order->setCreatedAt(new \Datetime());

    $em->persist($order);
    $em->persist($product);
    $em->flush();

    // Reset cart
    $this->session->remove('cart');

    return $order;
  }
}