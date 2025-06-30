<?php

namespace AppModules\Cart\Domain\Repositories;


use AppModules\Cart\Application\DTOs\IncDecCartDTO;
use AppModules\Cart\Domain\Entities\Cart;

interface CartRepositoryInterface
{

    public function addToCart(IncDecCartDTO $addToCartDTO): ?Cart;

    public function decreaseQuantity(IncDecCartDTO $decCartDTO): ?Cart;

    public function viewCart(): ?array;


}
