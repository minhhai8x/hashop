<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Order
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
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
     * @ORM\Column(name="order_no", type="string", length=256)
     */
    private $orderNo;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string", length=512)
     */
    private $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_email", type="string", length=512, nullable = true)
     */
    private $customerEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_address", type="string", length=512)
     */
    private $customerAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_phone", type="string", length=255)
     */
    private $customerPhone;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total = 0;

    /**
     * @var text
     *
     * @ORM\Column(name="customer_note", type="text", nullable = true)
     */
    private $customerNote;

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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="order", cascade={"persist"})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set orderNo
     *
     * @param string $time
     * @return Order
     */
    public function setOrderNo($time)
    {
        $this->orderNo = 'SNF' . base64_encode($time);

        return $this;
    }

    /**
     * Get orderNo
     *
     * @return string
     */
    public function getOrderNo()
    {
        return $this->orderNo;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     * @return Order
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     * @return Order
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set customerAddress
     *
     * @param string $customerAddress
     * @return Order
     */
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;

        return $this;
    }

    /**
     * Get customerAddress
     *
     * @return string
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Set customerPhone
     *
     * @param string $customerPhone
     * @return Order
     */
    public function setCustomerPhone($customerPhone)
    {
        $this->customerPhone = $customerPhone;

        return $this;
    }

    /**
     * Get customerPhone
     *
     * @return string
     */
    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set customerNote
     *
     * @param string $customerNote
     * @return Order
     */
    public function setCustomerNote($customerNote)
    {
        $this->customerNote = $customerNote;

        return $this;
    }

    /**
     * Get customerNote
     *
     * @return string
     */
    public function getCustomerNote()
    {
        return $this->customerNote;
    }

    /**
     * Set created_at
     *
     * @param DateTime $date
     * @return Order
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
     * @return Order
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
}

