<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use TweedeGolf\MediaBundle\Model\AbstractFile;

/**
 * @ORM\Entity
 * @ORM\Table
 * @ORM\Entity(repositoryClass="TweedeGolf\MediaBundle\Entity\FileRepository")
 */
class File extends AbstractFile
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
