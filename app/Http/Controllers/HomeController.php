<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $value = Transaction::all();

        $value = $value->unique('invoice_number');

        if (auth()->user()->hasRole('merchant')) {
            $merchant = Merchant::where('user_id', auth()->id())->first();
            $value = Transaction::where('merchant_id', $merchant->id)->get();
        } else if (auth()->user()->hasRole('customer')) {
            $value = Transaction::where('user_id', auth()->id())->get();
        }

        // hitung total transaksi
        $total = $value->sum('total');
        return view('dashboard', compact('total'));
    }
}
