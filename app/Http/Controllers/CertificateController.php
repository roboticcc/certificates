<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivateRequest;
use App\Http\Requests\OrderRequest;
use App\Mail\CertificateDetails;
use App\Models\Balance;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;


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

    public function order(OrderRequest $orderRequest)
    {
        $buyer_name = $orderRequest->buyer_name;
        $buyer_surname = $orderRequest->buyer_surname;
        $buyer_email = $orderRequest->buyer_email;
        $tree = $orderRequest->tree;
        $amount = $orderRequest->amount;
        $cost = $amount * 39;
        $activation_key = Str::random(10);

        Certificate::create([
            'buyer_name' => $buyer_name,
            'buyer_surname' => $buyer_surname,
            'buyer_email' => $buyer_email,
            'tree' => $tree,
            'amount' => $amount,
            'cost' => $cost,
            'activation_key' => $activation_key
        ]);

        $balance = Balance::find(1);
        $balance->update([
            'balance_remaining' => $this->current_balance - $cost
        ]);

        Mail::to($buyer_email)->send(new CertificateDetails($buyer_name, $buyer_surname, $tree, $amount, $cost, $activation_key));

        return redirect('/');
    }

    public function activate(ActivateRequest $activateRequest)
    {
        $activation_key = $activateRequest->activation_key;

        $certificate = Certificate::where('activation_key', $activation_key)->get();

        foreach ($certificate as $item) {
            if ($item) {
                $item->update([
                    'status' => 1
                ]);
                return redirect('/');
            }
        }

        return 'Unable to locate certificate with provided key';
    }
}
