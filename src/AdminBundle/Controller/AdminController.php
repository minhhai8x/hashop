<?php

namespace AdminBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use AppBundle\Entity\Banner;
use AppBundle\Helpers\StringHelper;

class AdminController extends BaseAdminController
{
    public function createEditForm($entity, array $entityProperties)
    {
        $editForm = parent::createEditForm($entity, $entityProperties);
        if($entity instanceof Banner){
            $editForm->remove('type');
            $editForm->add('type', 'choice', array('choices' => array(
             '1' => 'top_banner.label', '2' => 'left_banner.label', '3' => 'bottom_banner.label', '4' => 'slider.label'
             )));
        }
        return $editForm;
    }

    public function createNewForm($entity, array $entityProperties)
    {
        $newForm = parent::createNewForm($entity, $entityProperties);
        if($entity instanceof Banner){
            $newForm->remove('type');
            $newForm->add('type', 'choice', array('choices' => array(
             '1' => 'top_banner.label', '2' => 'left_banner.label', '3' => 'bottom_banner.label', '4' => 'slider.label'
             )));
        }
        return $newForm;
    }

    public function prePersistEntity($entity)
    {
        if($entity instanceof Product){
            $slug = StringHelper::slugify($entity->getName());
            $entity->setSlug($slug);

            $this->_setThumbImages($entity->getImages());
        }

        if($entity instanceof Category){
            $slug = StringHelper::slugify($entity->getName());
            $entity->setSlug($slug);
        }
    }

    public function preUpdateEntity($entity)
    {
        if($entity instanceof Product){
            $slug = StringHelper::slugify($entity->getName());
            $entity->setSlug($slug);

            $this->_setThumbImages($slug, $entity->getImages());
        }

        if($entity instanceof Category){
            $slug = StringHelper::slugify($entity->getName());
            $entity->setSlug($slug);
        }
    }

    private function _setThumbImages($productSlug, $thumbImages)
    {
        if ($thumbImages) {
            $images = $thumbImages->toArray();
            $haveMain = false;
            foreach ($images as $key => $image) {
                if ($image->getIsMain()) {
                    $haveMain = true;
                }

                $thumbImageName = $productSlug . '-thumb-' . sprintf('%02d', ($key+1));
                $image->setName($thumbImageName);
            }

            if (!$haveMain) {
                $images[0]->setIsMain(true);
            }
        }
    }
}

