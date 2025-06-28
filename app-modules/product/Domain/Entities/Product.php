<?php

namespace AppModules\product\Domain\Entities;

use Exception;

class Product
{
    public function __construct(
        public ?int    $id,
        public string  $name,
        public string  $slug,
        public ?string $description,
        public float   $price,
        public int     $stock,
        public string  $sku,
        public bool    $is_active,
        public bool    $is_featured,
        public ?array  $images = [],
        public array   $categories = []
    )
    {

    }

    /**
     * @return array|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @return string|null
     */


    /**
     * @return bool
     */
    public function isFeatured(): bool
    {
        return $this->is_featured;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function reduceStock(int $amount): void
    {
        if ($amount > $this->stock) {
            throw new Exception(message: "No Enough Stock Available");
        }

        $this->stock -= $amount;
    }
}
