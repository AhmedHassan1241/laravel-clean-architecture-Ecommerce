<?php

namespace AppModules\product\Application\DTOs;

class CreateProductDTO
{
    public function __construct(
        private ?int    $id,
        private string  $name,
        private string  $slug,
        private ?string $description,
        private float   $price,
        private int     $stock,
        private string  $sku,
        private bool    $is_active,
        private bool    $is_featured,
        private ?string $image,
        private array   $categories = []
    )
    {

    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

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

}
