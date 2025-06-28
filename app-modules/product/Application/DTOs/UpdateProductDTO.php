<?php

namespace AppModules\product\Application\DTOs;

class UpdateProductDTO
{
    public function __construct(
        private ?int    $id,
        private ?string $name,
        private ?string $slug,
        private ?string $description,
        private ?float  $price,
        private ?int    $stock,
        private ?string $sku,
        private ?bool   $is_active,
        private ?bool   $is_featured,
        private ?array  $images,
//        private ?UploadedFile $main_image = null,
        private ?array  $categories = [],
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
     * @return bool|null
     */
    public function getIsFeatured(): ?bool
    {
        return $this->is_featured;
    }

    /**
     * @return array|null
     */
    public function getCategories(): ?array
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
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
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return int|null
     */
    public function getStock(): ?int
    {
        return $this->stock;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

}
