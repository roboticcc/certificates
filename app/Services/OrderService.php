<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Mail\CertificateDetails;
use App\Models\Balance;
use App\Models\Certificate;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

/**
 * Service for ordering a new tree
 */
class OrderService
{
    protected ?string $current_balance;

    public function __construct()
    {
        $balance = Balance::find(1);
        $this->current_balance = $balance->balance_remaining;
    }

    /**
     * @throws Throwable
     *
     * Method to order a tree, registers new request and sends certificate to the provided email
     */
    public function order(OrderRequest $orderRequest)
    {
        $buyer_name = $orderRequest->buyer_name;
        $buyer_surname = $orderRequest->buyer_surname;
        $buyer_email = $orderRequest->buyer_email;
        $tree = $orderRequest->tree;
        $amount = $orderRequest->amount;
        $cost = $amount * 39;
        $activation_key = Str::random(10);

        DB::beginTransaction();

        try {
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

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        Mail::to($buyer_email)->send(new CertificateDetails($buyer_name, $buyer_surname, $tree, $amount, $cost, $activation_key));
    }
}
