<?php

namespace App\Http\Controllers\Backend\Order;

use App\Merchant\MerchantRepository;
use App\Order\OrderRepository;
use App\Order\OrderService;
use App\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    protected $order,$user;

    public function __construct(OrderRepository $order, UserRepository $user) {
        $this->order    = $order;
        $this->user     = $user;
    }

    public function index(Request $request){
        $filters    = $request->all();
        $orders     = $this->order->getOrders($filters,25);
        $sum        = $this->order->getOrders($filters,false);

        return view('backend.order.index', compact('orders','filters','sum'));
    }

    public function detail($id = null){
        $order      = $this->order->find($id);


        return view('backend.order.detail', compact('order'));
    }

    public function customSmsForm($id = null, Request $request){
        $order  = $this->order->find($id);
        $sms    = $this->order->getSms($id);

        return view('backend.order.sms-custom', compact('order','sms'));
    }

    public function customSmsSave($id = null, Request $request){
        $message    = $request->get('message');
        $order      = $this->order->customSms($id, $message);

        alertNotify((boolean)$order, "Sms sent", $request);

        return redirect(url('backend/order/detail/' . $id));
    }

    public function updateNote($orderId = null, Request $request){
        $note       = $request->get('admin_order_note');
        $result     = $this->order->updateNote($orderId, $note);
        alertNotify((boolean)$result, "Note update", $request);


        return redirect(url('backend/order/detail/' . $orderId));
    }

    public function confirmPaid($orderId = null, Request $request){
        $note       = $request->get('admin_order_note');
        $paidBy     = $request->get('paid_by');
        $result     = $this->order->confirmOrder($orderId, $paidBy, $note);

    }
}
