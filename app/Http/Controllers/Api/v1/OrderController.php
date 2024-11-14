<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\CreateOrderAction;
use App\Actions\UpdateOrderAction;
use App\DTOs\OrderDTO;
use App\DTOs\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreOrderRequest;
use App\Http\Requests\Api\v1\UpdateOrderRequest;
use App\Http\Resources\v1\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(Order::latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, CreateOrderAction $createOrderAction): OrderResource
    {
        $order = $createOrderAction->handle(
           data: OrderDTO::fromStoreRequest($request),
           user: UserDTO::fromEloquentModel(request()->user()),
        );

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): OrderResource
    {
        $order->load(['user', 'items']);

        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order, UpdateOrderAction $updateOrderAction): OrderResource
    {
        $order = $updateOrderAction->handle(
            order: $order,
            data: OrderDTO::fromUpdateRequest($request),
            user: UserDTO::fromEloquentModel(request()->user()),
        );

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return $this->success(message: 'The order has been deleted succesfully');
    }
}
