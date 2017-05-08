<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Configuration
 *
 * @ORM\Table(name="configuration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigurationRepository")
 * @Vich\Uploadable
 */
class Configuration
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_name", type="string", length=255, nullable=true)
     */
    private $wsName;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_title", type="string", length=255, nullable=true)
     */
    private $wsTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_slogan", type="string", length=255, nullable=true)
     */
    private $wsSlogan;

    /**
     * 
     * @Vich\UploadableField(mapping="ws_logo_image", fileNameProperty="wsLogo")
     * 
     * @var UploadedFile
     */
    private $wsLogoFile;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_logo", type="string", length=255, nullable=true)
     */
    private $wsLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_address", type="string", length=255, nullable=true)
     */
    private $wsAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_phone", type="string", length=255, nullable=true)
     */
    private $wsPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="ws_copyright", type="string", length=255, nullable=true)
     */
    private $wsCopyright;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set wsName
     *
     * @param string $wsName
     * @return Configuration
     */
    public function setWsName($wsName)
    {
        $this->wsName = $wsName;

        return $this;
    }

    /**
     * Get wsName
     *
     * @return string 
     */
    public function getWsName()
    {
        return $this->wsName;
    }

    /**
     * Set wsTitle
     *
     * @param string $wsTitle
     * @return Configuration
     */
    public function setWsTitle($wsTitle)
    {
        $this->wsTitle = $wsTitle;

        return $this;
    }

    /**
     * Get wsTitle
     *
     * @return string 
     */
    public function getWsTitle()
    {
        return $this->wsTitle;
    }

    /**
     * Set wsSlogan
     *
     * @param string $wsSlogan
     * @return Configuration
     */
    public function setWsSlogan($wsSlogan)
    {
        $this->wsSlogan = $wsSlogan;

        return $this;
    }

    /**
     * Get wsSlogan
     *
     * @return string 
     */
    public function getWsSlogan()
    {
        return $this->wsSlogan;
    }

    /**
     * Set wsLogoFile
     *
     * @param File $wsLogoFile
     * @return Configuration
     */
    public function setWsLogoFile(File $wsLogoFile = null)
    {
        $this->wsLogoFile = $wsLogoFile;
        if ($wsLogoFile instanceof UploadedFile) {
            $this->setWsLogo($wsLogoFile->getClientOriginalName());
        }
    }

    /**
     * Get wsLogoFile
     *
     * @return File|null 
     */
    public function getWsLogoFile()
    {
        return $this->wsLogoFile;
    }

    /**
     * Set wsLogoFile
     *
     * @param $wsLogo
     * @return Configuration
     */
    public function setWsLogo($wsLogo)
    {
        $this->wsLogo = $wsLogo;
    }

    /**
     * Get wsLogo
     *
     * @return String
     */
    public function getWsLogo()
    {
        return $this->wsLogo;
    }

    /**
     * Set wsAddress
     *
     * @param string $wsAddress
     * @return Configuration
     */
    public function setWsAddress($wsAddress)
    {
        $this->wsAddress = $wsAddress;

        return $this;
    }

    /**
     * Get wsAddress
     *
     * @return string 
     */
    public function getWsAddress()
    {
        return $this->wsAddress;
    }

    /**
     * Set wsPhone
     *
     * @param string $wsPhone
     * @return Configuration
     */
    public function setWsPhone($wsPhone)
    {
        $this->wsPhone = $wsPhone;

        return $this;
    }

    /**
     * Get wsPhone
     *
     * @return string 
     */
    public function getWsPhone()
    {
        return $this->wsPhone;
    }

    /**
     * Set wsCopyright
     *
     * @param string $wsCopyright
     * @return Configuration
     */
    public function setWsCopyright($wsCopyright)
    {
        $this->wsCopyright = $wsCopyright;

        return $this;
    }

    /**
     * Get wsCopyright
     *
     * @return string 
     */
    public function getWsCopyright()
    {
        return $this->wsCopyright;
    }

    public function __toString()
    {
        return $this->wsName; 
    }
}
