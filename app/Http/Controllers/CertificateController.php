<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivateRequest;
use App\Http\Requests\OrderRequest;
use App\Mail\CertificateDetails;
use App\Models\Balance;
use App\Models\Certificate;
use App\Services\ActivationService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use Throwable;


class CertificateController extends Controller
{
    protected $current_balance;

    public function __construct()
    {
        $balance = Balance::find(1);
        $this->current_balance = $balance->balance_remaining;
    }

    public function index()
    {
        $active_certificates = Certificate::where('status', 1)->orderBy('updated_at', 'asc')->paginate(3);

        return view('index', [
            'current_balance' => $this->current_balance,
            'active_certificates' => $active_certificates
        ]);
    }

    /**
     * @throws Throwable
     */
    public function order(OrderRequest $orderRequest)
    {
        $service = new OrderService();
        $service->order($orderRequest);

        return redirect('/');
    }

    public function activate(ActivateRequest $activateRequest)
    {
        $service = new ActivationService();

        if ($service->activate($activateRequest)){
                return redirect('/');
        }

        return 'Unable to locate certificate with provided key';
    }
}
