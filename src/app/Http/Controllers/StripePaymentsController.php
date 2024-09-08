<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StripePaymentsController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        return $user->checkout(config('stripe.price_id'), [
            'success_url' => route('success'),
            'cancel_url' => route('cancel'),
            'line_items' => [
                [
                'price' => 'price_1PwPwZ09PwPOlvq8wDv4ci9S',
                'quantity' => 1,
                ],
            ],
        ]);
    }
}
