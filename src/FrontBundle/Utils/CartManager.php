<?php

namespace FrontBundle\Utils;

class CartManager
{
  protected $session;
  protected $productManager;


  /**
   * Constructs the CartManager instance
   *
   * @param Container $container
   */
  public function __construct($container)
  {
    $this->session = $container->get('session');
    $this->productManager = $container->get('utils.product.manager');
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

    if (isset($cart[$id]) && --$cart[$id] == 0)
    {
      unset($cart[$id]);
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
}