<?php

namespace AppModules\Cart\Domain\Entities;

use InvalidArgumentException;

class Cart
{

    public function __construct(
        public ?int    $id,
        public int     $user_id,
        public int     $product_id,
        public int     $quantity = 1,
        public float   $price,
        public ?float  $subTotalPrice = null,
        public ?string $productName = null,
        public ?string $productSlug = null,
        public ?string $productDescription = null,
        public ?string $productStock = null,
        public ?string $productImage = null,

    )
    {
    }

    /**
     * @return string|null
     */
    public function getProductImage(): ?string
    {
        return $this->productImage;
    }

    /**
     * @return float|null
     */
    public function getSubTotalPrice(): ?float
    {
        return $this->subTotalPrice;
    }

    /**
     * @return string|null
     */
    public function getProductSlug(): ?string
    {
        return $this->productSlug;
    }

    /**
     * @return string|null
     */
    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    /**
     * @return string|null
     */
    public function getProductStock(): ?string
    {
        if (is_null($this->productStock)) {
            return 'Unknown';
        }
        return $this->productStock ? 'In Stock' : 'Out of Stock';
    }

    /**
     * @return string|null
     */
    public function getProductName(): ?string
    {
        return $this->productName;
    }

    /**
     * @return string|null
     */


    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            throw new InvalidArgumentException('Quantity Must Be Greater Than 1');
        }
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}
