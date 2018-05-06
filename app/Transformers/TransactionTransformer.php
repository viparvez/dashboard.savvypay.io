<?php

namespace App\Transformers;

use App\Transaction;
use App\User;
use Fractal;
use League\Fractal\TransformerAbstract;
use App\Settlement;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id'         => (int) $transaction->id,
            'number'     => $transaction->trxnnum,
            'amount'     => (float)$transaction->amount,
            'user'       => $transaction->User,
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at,
            'gateway'    => $transaction->Gateway,
            'status'     => $transaction->status
        ];
    }
}
