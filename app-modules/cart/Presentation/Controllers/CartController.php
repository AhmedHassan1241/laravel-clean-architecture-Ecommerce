<?php

namespace AppModules\cart\Presentation\Controllers;

use App\Http\Controllers\Controller;
use AppModules\Cart\Application\DTOs\IncDecCartDTO;
use AppModules\Cart\Application\UseCases\AddToCartUseCase;
use AppModules\Cart\Application\UseCases\DecreaseQuantityUseCase;
use AppModules\Cart\Application\UseCases\ViewCartUseCase;
use AppModules\Cart\Presentation\Requests\IncDecCartRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class CartController extends Controller
{
    public function __construct(
        private AddToCartUseCase        $addToCartUseCase,
        private ViewCartUseCase         $viewCartUseCase,
        private DecreaseQuantityUseCase $decreaseQuantityUseCase
    )
    {

    }

    public function addToCart(IncDecCartRequest $request): JsonResponse
    {
        try {

            if (!Auth::check()) {
                return response()->json(['message' => 'You must be logged in to perform this action.'], 401);
            }
            $userId = Auth::id();
            $data = $request->validated();
            $cartItemDTO = new IncDecCartDTO($userId, $data['productId'], $data['quantity'] ?? 1);
            $addItem = $this->addToCartUseCase->execute($cartItemDTO);
            if (!$addItem) {
                return response()->json(['message' => 'Unable to add to cart'], 400);
            }

            return response()->json(['message' => 'Item added to cart successfully', 'Item Added' => $addItem]);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Unexpected error occurred.'
            ], 500);
        }

    }

    public function decreaseQuantity(IncDecCartRequest $request): JsonResponse
    {
        try {

            if (!Auth::check()) {
                return response()->json(['message' => 'You must be logged in to perform this action.'], 401);
            }
            $userId = Auth::id();
            $data = $request->validated();
            $cartItemDTO = new IncDecCartDTO($userId, $data['productId'], $data['quantity'] ?? 1);
            $decreaseItem = $this->decreaseQuantityUseCase->execute($cartItemDTO);
            if (!$decreaseItem) {
                return response()->json(['message' => 'Item Removed From cart'], 200);
            }
            return response()->json(['message' => "Item Quantity Decreased successfully", 'Item ' => $decreaseItem]);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Unexpected error occurred.'
            ], 500);
        }

    }

    public function removeFromCart()
    {

    }

    public function viewCart(): JsonResponse
    {


        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in to perform this action.'], 401);
        }
        $cartItems = $this->viewCartUseCase->execute();
        if (!$cartItems) {
            return response()->json(['message' => 'No Items In Cart.'], 404);
        }

        return response()->json(['Cart Items : ' => $cartItems], 200);


    }
}
