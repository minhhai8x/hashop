<?php

namespace AppBundle\Helpers;

use Doctrine\ORM\EntityManager;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use AppBundle\Helpers\StringHelper;

class ProductImageNamer implements NamerInterface
{
    /**
     * Creates a name for the file being uploaded.
     *
     * @param object $object The object the upload is attached to.
     * @param PropertyMapping $mapping Property Mapping.
     * @return string $fileName The file name.
     */
    function name($object, PropertyMapping $mapping)
    {
        $slug      = StringHelper::slugify($object->getName());
        $file      = $object->getImageFile();
        $extension = $file->getClientOriginalExtension();
        $fileName  =  $slug . '_' . time() . '.' . $extension;

        return $fileName;
    }
}