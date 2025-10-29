<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Order;
}
