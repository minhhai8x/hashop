<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
	protected $productManager;

    public function __construct($container)
    {
        $this->productManager = $container->get('utils.product.manager');
    }

    public function getFunctions() {
        return array(
            'global_configs' => new \Twig_Function_Method($this, 'getGlobalConfigs')
        );
    }

    public function getGlobalConfigs()
    {

        return $this->productManager->getGlobalConfigs();
    }
}