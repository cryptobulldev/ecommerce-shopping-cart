<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function store(): RedirectResponse
    {
        $order = $this->orderService->checkout();
        return back()->with('success', "Order #{$order->id} placed successfully!");
    }
}
