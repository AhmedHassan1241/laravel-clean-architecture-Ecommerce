<?php

namespace AppModules\Cart\Application\UseCases;


use AppModules\Cart\Domain\Services\CartServies;

class ViewCartUseCase
{
    public function __construct(private CartServies $cartServies)
    {

    }

    public function execute(): ?array
    {
        return $this->cartServies->viewCart();
    }

}
