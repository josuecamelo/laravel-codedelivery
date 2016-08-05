<?php
/**
 * Created by PhpStorm.
 * User: jcamelo
 * Date: 23/06/16
 * Time: 16:17
 */

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Illuminate\Http\Request;

class DeliverymanCheckoutController extends Controller
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
        
        /*$orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use($id) {
            return $query->where('user_deliveryman_id','=',$id);
        })->paginate();

        return $orders;*/

        $orders = $this->orderRepository
            ->skipPresenter(false)
            ->with($this->whith)
            ->scopeQuery(function($query) use ($id){
                return $query->where('user_deliveryman_id','=',$id);
            })->paginate();
        return $orders;
    }

    public function show($id)
    {
        $user_deliveryman_id = Authorizer::getResourceOwnerId();
        return $this->orderRepository
            ->skipPresenter(false)
            ->getByIdAndDeliveryman($id, $user_deliveryman_id);
    }

    public function updateStatus(Request $request, $id){
        $user_deliveryman_id = Authorizer::getResourceOwnerId();
        $order = $this->orderService->updateStatus($id, $user_deliveryman_id, $request->get('status'));
        if($order) {
            //return $order;
            return $this->orderRepository->find($order->id);
        }

        abort(400, 'Order não encontrada!');
    }
}