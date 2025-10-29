<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(): Response
    {
        $products = $this->productService->getAll();

        return Inertia::render('Products/Index', ['products' => $products]);
    }
}
