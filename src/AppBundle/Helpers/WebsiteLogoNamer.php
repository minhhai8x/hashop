<?php

namespace AppBundle\Helpers;

use Doctrine\ORM\EntityManager;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;

class WebsiteLogoNamer implements NamerInterface
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
        $file      = $object->getWsLogoFile();
        $extension = $file->getClientOriginalExtension();
        $fileName  = 'logo_' . time() . '.' . $extension;

        return $fileName;
    }
}