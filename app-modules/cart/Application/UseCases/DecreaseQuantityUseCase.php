<?php

namespace AppModules\Cart\Application\UseCases;


use AppModules\Cart\Application\DTOs\IncDecCartDTO;
use AppModules\Cart\Domain\Entities\Cart;
use AppModules\Cart\Domain\Services\CartServies;

class DecreaseQuantityUseCase
{
    public function __construct(private CartServies $cartServies)
    {

    }

    public function execute(IncDecCartDTO $decCartDTO): ?Cart
    {
        return $this->cartServies->decreaseQuantity($decCartDTO);
    }

}
