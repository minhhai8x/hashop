<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Product
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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="spec_price", type="float")
     */
    private $specPrice = 0;

    /**
     * @var datetime $created
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable = true)
     */
    private $updatedAt;

    /**
     * @var Image[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Image", cascade={"persist"})
     * @ORM\JoinTable(name="product_images",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $images;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_best_seller", type="boolean")
     */
    private $isBestSeller = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_showed", type="boolean")
     */
    private $isShowed = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

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
     * Set category
     *
     * @param string $category
     * @return Product
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return array
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set specPrice
     *
     * @param float $specPrice
     * @return Product
     */
    public function setSpecPrice($specPrice)
    {
        $this->specPrice = $specPrice;

        return $this;
    }

    /**
     * Get specPrice
     *
     * @return float
     */
    public function getSpecPrice()
    {
        return $this->specPrice;
    }

    /**
     * Set created_at
     *
     * @param DateTime $date
     * @return Product
     */
    public function setCreatedAt($date)
    {
        $this->createdAt = $date;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updated_at
     *
     * @param DateTime $date
     * @return Product
     */
    public function setUpdatedAt($date)
    {
        $this->updatedAt = $date;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Get images
     *
     * @return Image[]|ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set isBestSeller
     *
     * @param boolean $isBestSeller
     * @return Product
     */
    public function setIsBestSeller($isBestSeller)
    {
        $this->isBestSeller = $isBestSeller;

        return $this;
    }

    /**
     * Get isBestSeller
     *
     * @return boolean
     */
    public function getIsBestSeller()
    {
        return $this->isBestSeller;
    }

    /**
     * Set isShowed
     *
     * @param boolean $isShowed
     * @return Product
     */
    public function setIsShowed($isShowed)
    {
        $this->isShowed = $isShowed;

        return $this;
    }

    /**
     * Get isShowed
     *
     * @return boolean
     */
    public function getIsShowed()
    {
        return $this->isShowed;
    }
}
