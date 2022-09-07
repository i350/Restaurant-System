<?php

namespace App\Http\Controllers\Api;

use App\Actions\Orders\PrepareOrder;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var Builder $orders */
        $orders = auth()->user()->orders();
        return OrderResource::collection($orders->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, PrepareOrder $prepareOrder): OrderResource
    {
        // Early stock check
        $request->checkStockAvailability();

        // Prepare order
        $order = $prepareOrder($request->getProducts(), $request->getQuantities());

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }
}
