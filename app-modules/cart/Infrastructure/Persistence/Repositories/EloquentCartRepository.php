<?php

namespace AppModules\Cart\Infrastructure\Persistence\Repositories;

use AppModules\Cart\Application\DTOs\IncDecCartDTO;
use AppModules\Cart\Domain\Entities\Cart;
use AppModules\Cart\Domain\Repositories\CartRepositoryInterface;
use AppModules\Cart\Infrastructure\Mapper\CartMapper;
use AppModules\cart\Infrastructure\Persistence\Models\CartModel;
use AppModules\Product\Infrastructure\Persistence\Models\ProductModel;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class EloquentCartRepository implements CartRepositoryInterface
{
    public function addToCart(IncDecCartDTO $addToCartDTO): ?Cart
    {
        $product = ProductModel::find($addToCartDTO->getProductId());
        if (!$product) {
            throw new InvalidArgumentException('Product Not Found');
        }

        $cartModel = CartModel::where('user_id', $addToCartDTO->getUserId())->where('product_id', $addToCartDTO->getProductId())->first();

        $requestQuantity = $addToCartDTO->getQuantity();
        $currentQuantity = $cartModel->quantity ?? 0;
        $totalQuantity = $currentQuantity + $requestQuantity;
        if ($product->stock < $totalQuantity) {
            throw new InvalidArgumentException('Cant Add This Item ,No Quantity Available', 422);
        } else {

            if ($cartModel) {
                $cartModel->quantity = $totalQuantity;
            } else {
                $addItem = new Cart(
                    id: null,
                    user_id: $addToCartDTO->getUserId(),
                    product_id: $addToCartDTO->getProductId(),
                    quantity: $addToCartDTO->getQuantity(),
                    price: $product->price,

                );
                $cartModel = new CartModel();
                $cartModel->fill([
                        'user_id' => $addItem->getUserId(),
                        'product_id' => $addItem->getProductId(),
                        'quantity' => $addItem->getQuantity(),
                        'price' => $addItem->getPrice()
                    ]
                );
            }
            $cartModel->save();
            return CartMapper::mapToDomain($cartModel);
        }
    }

    public function decreaseQuantity(IncDecCartDTO $decCartDTO): ?Cart
    {
        $product = ProductModel::find($decCartDTO->getProductId());
        if (!$product) {
            throw new InvalidArgumentException('Product Not Found');
        }
        $cartModel = CartModel::where('user_id', $decCartDTO->getUserId())->where('product_id', $decCartDTO->getProductId())->first();
        if (!$cartModel) {
            throw new InvalidArgumentException('Item not found in cart');
        }

        $requestQuantity = $decCartDTO->getQuantity();
        $currentQuantity = $cartModel->quantity;

        if ($currentQuantity < $requestQuantity) {
            throw new InvalidArgumentException('Requested quantity exceeds the quantity in cart');
        }
        $cartModel->quantity = $currentQuantity - $requestQuantity;
        if ($cartModel->quantity <= 0) {
            $cartModel->delete();
            return null;
        }
        $cartModel->save();


//        dd($cartModel->quantity);

        return CartMapper::mapToDomain($cartModel);
    }


    public function viewCart(): ?array
    {
        $userId = Auth::id();
        $cartModels = CartModel::with('product')->where('user_id', $userId)->get();
        return !$cartModels ? null : $cartModels->map(fn($cartModel) => CartMapper::mapToDomain($cartModel))->toArray();
    }
}
