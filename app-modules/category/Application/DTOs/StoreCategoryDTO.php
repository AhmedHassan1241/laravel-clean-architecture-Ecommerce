<?php

namespace AppModules\Category\Application\DTOs;


use Illuminate\Support\Str;

class StoreCategoryDTO
{
    public function __construct(public ?int $id, public string $name, public ?string $slug, public ?string $description, public ?bool $is_active, public ?int $parent_id)
    {

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
     * @return string|null
     */
    public function getSlug(): ?string
    {

        return $this->slug ?? Str::slug($this->name);
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

}
