<?php

namespace AppBundle\Twig;

use AppBundle\Helpers\StringHelper;

class AppExtension extends \Twig_Extension
{
	protected $globalManager;
    protected $cartManager;
    protected $defaultLogo;
    protected $logoPath;

    public function __construct($container)
    {
        $this->globalManager = $container->get('utils.global.manager');
        $this->cartManager   = $container->get('utils.cart.manager');
        $this->defaultLogo   = $container->getParameter('front_website_logo_default');
        $this->logoPath      = $container->getParameter('front_website_logo_path');
    }

    public function getFunctions() {
        return array(
            'global_configs' => new \Twig_Function_Method($this, 'getGlobalConfigs'),
            'price_format' => new \Twig_Function_Method($this, 'priceFormat'),
            'cart_total' => new \Twig_Function_Method($this, 'getCartTotal'),
        );
    }

    public function getGlobalConfigs()
    {
        $logoImage = $this->defaultLogo;
        $globalConfigs = $this->globalManager->getGlobalConfigs();
        if ($globalConfigs->getWsLogo() && file_exists($this->logoPath . $globalConfigs->getWsLogo())) {
            $logoImage = '/'. $this->logoPath . $globalConfigs->getWsLogo();
        }

        $globalConfigs->logoImage = $logoImage;

        $theme = $globalConfigs->getWsTheme();
        switch ($theme) {
            case 1:
                $globalConfigs->theme_style = 'style_orange.css';
                break;

            default:
                $globalConfigs->theme_style = 'style.css';
                break;
        }

        return $globalConfigs;
    }

    public function priceFormat($price)
    {
        return StringHelper::currency($price);
    }

    public function getCartTotal()
    {
        $cartData = $this->cartManager->getCart();
        return $cartData['count'];
    }
}