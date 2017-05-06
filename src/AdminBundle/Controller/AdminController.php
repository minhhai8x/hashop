<?php

namespace AdminBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use AppBundle\Entity\Product;
use AppBundle\Helpers\StringHelper;

class AdminController extends BaseAdminController
{
    public function createEditForm($entity, array $entityProperties)
    {
        $editForm = parent::createEditForm($entity, $entityProperties);
        if($entity instanceof Product){
            $editForm->remove('description');
            $editForm->add('description', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'advanced',
                )
            ));
        }
        return $editForm;
    }

    public function prePersistEntity($entity)
    {
        if($entity instanceof Product){
            $slug = StringHelper::slugify($entity->getName());
            $entity->setSlug($slug);
        }
    }
}

