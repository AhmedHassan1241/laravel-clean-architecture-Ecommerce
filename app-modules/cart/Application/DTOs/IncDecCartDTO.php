<?php

namespace AppModules\Cart\Application\DTOs;


class IncDecCartDTO
{
    public function __construct(
        private int $userId,
        private int $productId,
        private int $quantity
    )
    {

    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
