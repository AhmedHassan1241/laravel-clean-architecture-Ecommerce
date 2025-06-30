<?php

namespace AppModules\Cart\Infrastructure\Mapper;

use AppModules\Cart\Domain\Entities\Cart;
use AppModules\cart\Infrastructure\Persistence\Models\CartModel;

class CartMapper
{
    public static function mapToDomain(CartModel $cartModel): Cart
    {

        return new Cart(
            id: $cartModel->id,
            user_id: $cartModel->user_id,
            product_id: $cartModel->product_id,
            quantity: $cartModel->quantity,
            price: $cartModel->price,
            subTotalPrice: $cartModel->quantity * $cartModel->price,
            productName: $cartModel->product?->name,
            productSlug: $cartModel->product?->slug,
            productDescription: $cartModel->product?->description,
            productStock: $cartModel->product?->stock,
            productImage: $cartModel->product?->images->first() ? asset('public' . $cartModel->product?->images->first()?->image_path) : null,

        );
    }

//    public static function mapToArray(Cart $cart): array
//    {
//        return [
//            'id' => $cart->getId(),
//            'user_id' => $cart->getUserId(),
//            'product_id' => $cart->getProductId(),
//            'quantity' => $cart->getQuantity(),
//            'price' => $cart->getPrice(),
//            'product_name' => $cart->getProductName(),
//            'product_image' => $cart->getProductImage(),
//        ];
//    }
}
