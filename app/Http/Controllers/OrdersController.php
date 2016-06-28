<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $orders = $this->repository->paginate();

        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id, UserRepository $userRepository)
    {
        $sts = [0=>'Pendente', 1=>'A caminho', 2=>'Entregue',3=>'Cancelado'];
        
        $order = $this->repository->find($id);

        $deliveryman = $userRepository->getDeliveryMan();

        return view('admin.orders.edit', compact('order', 'sts','deliveryman'));
    }

    public function update(Request $request, $id)
    {
        $all = $request->all();
        $this->repository->update($all, $id);

        return redirect()->route('admin.orders.index');
    }
}
