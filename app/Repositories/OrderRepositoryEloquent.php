<?php

namespace CodeDelivery\Repositories;

use CodeDelivery\Presenters\OrderPresenter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Models\Order;
use CodeDelivery\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    protected $skipPresenter = true;

    public function getByIdAndDeliveryman($id, $user_deliveryman_id ){
        $result = $this->with(['items','cupom','client'])->findWhere([
            'id'=> $id,
            'user_deliveryman_id' => $user_deliveryman_id]
        );

        if($result instanceof Collection){
            $result = $result->first();
            /*if($result){
                $result->items->each(function($item){
                    $item->product;
                });
            }*/ //não é mais necessário
        }else{ // is array
            if(isset($result['data']) && count($result['data']) == 1){
                $result = ['data' => $result['data'][0]];
            }else{
                throw new ModelNotFoundException('Order não existe.');
            }
        }

        return $result;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

        

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /*public function presenter()
    {
        return \Prettus\Repository\Presenter\ModelFractalPresenter::class;
    }*/

    public function presenter()
    {
        return OrderPresenter::class;
    }
}
