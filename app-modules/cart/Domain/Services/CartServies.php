<?php

namespace AppModules\Cart\Domain\Services;

use AppModules\Cart\Application\DTOs\IncDecCartDTO;
use AppModules\Cart\Domain\Entities\Cart;
use AppModules\Cart\Domain\Repositories\CartRepositoryInterface;

class CartServies
{
    public function __construct(private CartRepositoryInterface $cartRepository)
    {

    }

    public function addToCart(IncDecCartDTO $addToCartDTO): ?Cart
    {
        return $this->cartRepository->addToCart($addToCartDTO);
    }

    public function viewCart(): ?array
    {
        return $this->cartRepository->viewCart();
    }

    public function decreaseQuantity(IncDecCartDTO $decCartDTO): ?Cart
    {
        return $this->cartRepository->decreaseQuantity($decCartDTO);
    }

}
