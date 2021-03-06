<?php
/**
 * Created by PhpStorm.
 * User: jcamelo
 * Date: 27/06/16
 * Time: 08:52
 */

namespace CodeDelivery\Services;


use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{
    private $repository;
    private $cupomRepository;
    private $productRepository;

    public function __construct(OrderRepository $repository,
                                CupomRepository $cupomRepository, ProductRepository $productRepository)
    {
        $this->repository = $repository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
    }


    public function create(array $data)
    {
        DB::beginTransaction();
        try{
            $data['status'] = 0;
            $data['total'] = 0;
            //$data['quantity'] = 0;

            if(isset($data['cupom_id'])){
                unset($data['cupom_id']);
            }

            if(isset($data['cupom_code'])){
                $cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
                $data['cupom_id'] =  $cupom->id;
                $cupom->used = 1;
                $cupom->save();
                unset($data['cupom_code']);
            }

            $items = $data['items'];
            unset($data['items']);

            $order = $this->repository->create($data);
            $total = 0.0;

            foreach($items as $item){
                $item['price'] = $this->productRepository->find($item['product_id'])->price;
                $order->items()->create($item);
                $total += $item['price'] * $item['quantity'];
            }
            
            $order->total = $total;

            if(isset($cupom)){
                $order->total = ($total - $cupom->value);
            }

            $order->save();
            DB::commit();

            return $order;
        }catch (\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function updateStatus($id, $user_deliveryman_id, $status){
        $order = $this->repository->getByIdAndDeliveryman($id, $user_deliveryman_id);
        if($order instanceof Order){
            $order->status = $status;
            $order->save();
            return $order;
        }

        return false;
    }
}