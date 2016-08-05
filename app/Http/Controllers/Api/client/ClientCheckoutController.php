<?php
/**
 * Created by PhpStorm.
 * User: jcamelo
 * Date: 23/06/16
 * Time: 16:17
 */

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OrderService
     */
    private $orderService;

    private $whith = ['client','cupom','items'];
    /**
     * CheckoutController constructor.
     * @param OrderRepository $orderRepository
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        OrderService $orderService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        /*$orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id','=',$clientId);
        })->paginate();

        return $orders;*/

        $orders = $this->orderRepository
            ->skipPresenter(false)
            ->with($this->whith)
            ->scopeQuery(function($query) use ($clientId){
                return $query->where('client_id','=',$clientId);
            })->paginate(5);
        return $orders;
    }

    public function store(Requests\CheckoutRequest $request)
    {
        $id = Authorizer::getResourceOwnerId();
        $data = $request->all();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $o = $this->orderService->create($data);

        return $this->orderRepository
            ->with(['items'])
            ->find($o->id);
    }

    public function show($id)
    {
        $idUser = Authorizer::getResourceOwnerId();
        return $this->orderRepository
            ->skipPresenter(false)//pode ser sem ->skipPresenter passando true sem passar nada
            ->with($this->whith)
            ->findWhere(['client_id'=>$idUser,'id'=>$id]);

        //sem presenter
       /*$o =  $this->orderRepository
            ->with(['client', 'items', 'cupom'])
            ->find($id);*/
        /*$o->items->each(function($item){
            $item->product;
        });*/ //com presenter remover $o->items
        return $o;
    }
}