<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
	protected $globalManager;
    protected $defaultLogo;
    protected $logoPath;

    public function __construct($container)
    {
        $this->globalManager = $container->get('utils.global.manager');
        $this->defaultLogo    = $container->getParameter('front_website_logo_default');
        $this->logoPath       = $container->getParameter('front_website_logo_path');
    }

    public function getFunctions() {
        return array(
            'global_configs' => new \Twig_Function_Method($this, 'getGlobalConfigs')
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

        return $globalConfigs;
    }
}