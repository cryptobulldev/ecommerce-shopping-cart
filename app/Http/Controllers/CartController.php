<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index(): Response
    {
        return Inertia::render('Cart/Index', [
            'cart' => $this->cartService->getAll(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $this->cartService->add($validated['product_id'], $validated['quantity']);

        return back()->with('success', 'Added to cart');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->cartService->update($id, $request->quantity);

        return back()->with('success', 'Cart updated');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->cartService->remove($id);

        return back()->with('success', 'Removed from cart');
    }
}
