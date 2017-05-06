<?php

namespace FrontBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use FrontBundle\DependencyInjection\FrontBundleExtension;

class FrontBundle extends Bundle
{
	public function getContainerExtension()
    {
        return new FrontBundleExtension();
    }
}
