<?php

namespace AppModules\Cart\Application\UseCases;


use AppModules\Cart\Application\DTOs\IncDecCartDTO;
use AppModules\Cart\Domain\Entities\Cart;
use AppModules\Cart\Domain\Services\CartServies;

class AddToCartUseCase
{

    public function __construct(private CartServies $cartServies)
    {

    }

    public function execute(IncDecCartDTO $addToCartDTO): ?Cart
    {
        return $this->cartServies->addToCart($addToCartDTO);
    }
}
