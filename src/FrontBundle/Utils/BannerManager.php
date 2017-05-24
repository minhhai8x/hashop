<?php

namespace FrontBundle\Utils;

use Doctrine\ORM\EntityManager;
use AppBundle\Helpers\StringHelper;

class BannerManager
{
    protected $em;
    protected $container;
    protected $bannerRepo;

    public function __construct(EntityManager $em, $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->bannerRepo = $em->getRepository('AppBundle:Banner');
    }

    /**
     *
     * Get list of banners
     *
     * @return array $results List of banners
     */
    public function getAllBanners()
    {
        $results = array();
        $banners = $this->bannerRepo->getAllBanners();

        if (!empty($banners)) {
            foreach ($banners as $banner) {
                switch ($banner['type']) {
                    case 1:
                        $results['top'][] = $banner;
                        break;
                    case 2:
                        $results['left'][] = $banner;
                        break;
                    case 3:
                        $results['bottom'][] = $banner;
                        break;
                    case 4:
                        $results['slider'][] = $banner;
                        break;

                    default:
                        break;
                }
            }
        }

        return $results;
    }
}
