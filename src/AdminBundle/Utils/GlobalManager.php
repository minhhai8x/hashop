<?php

namespace AdminBundle\Utils;

use Doctrine\ORM\EntityManager;
use AppBundle\Helpers\StringHelper;

class GlobalManager
{
    protected $em;
    protected $container;
    protected $productRepo;
    protected $imageRepo;

    public function __construct(EntityManager $em, $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->productRepo = $em->getRepository('AppBundle:Product');
        $this->imageRepo = $em->getRepository('AppBundle:Image');
    }

    /**
     *
     * Update product images
     *
     * @param  integer $productId
     * @param  array   $imagesAfter Product images which need to be updated
     */
    public function updateProductImages($productId, $imagesAfter)
    {
        // get all product images
        $productImages = $this->productRepo->getProductImages($productId);

        if ($imagesAfter) {
            $imgIds = array();
            foreach ($imagesAfter as $image) {
                $imgIds[] = $image->getId();
            }

            $setMainImage = false;
            foreach ($productImages as $img) {
                if (!in_array($img['id'], $imgIds)) {
                    // delete image
                    $this->deleteProductImage($img['id']);

                    // remove image file
                    $path = $this->container->getParameter('app.path.product_images');
                    $imagePath = '.' . $path . DIRECTORY_SEPARATOR . $img['image'];
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }

                    // set main image
                    if ($img['isMain']) {
                        $setMainImage = true;
                    }

                }
            }

            if ($setMainImage) {
                $mainImage = $imagesAfter->current();
                $mainImage->setIsMain(true);
                $this->em->persist($mainImage);
                $this->em->flush();
            }
        }
    }

    public function deleteProductImage($imageId)
    {
        $image = $this->imageRepo->find($imageId);
        $this->em->remove($image);
        $this->em->flush();
    }
}
