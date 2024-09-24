<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('merchant')) {
                $merchant = Merchant::where('user_id', auth()->id())->first();
                $transactions = Transaction::where('merchant_id', $merchant->id)->get();
            } else if (auth()->user()->hasRole('customer')) {
                $transactions = Transaction::where('user_id', auth()->id())->get();
            } else {
                $transactions = Transaction::all();
            }

            $transactions = $transactions->unique('invoice_number');

            return datatables()->of($transactions)
                ->addIndexColumn()
                ->addColumn('created', function ($row) {
                    $created = date('d F Y, H:i', strtotime($row->created_at));
                    return $created;
                })
                ->addColumn('delivery_date', function ($row) {
                    $delivery_date = date('d F Y, H:i', strtotime($row->delivery_date));
                    return $delivery_date;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('invoice.show', $row->invoice_number) . '" class="btn btn-secondary btn-sm me-2" title="Download PDF"><i class="fas fa-file-download"></i></a>';
                    return $btn;
                })
                ->rawColumns(['merchant', 'price', 'action'])
                ->make(true);
        } else {
            return view('invoice.index');
        }
    }

    public function show($invoice_number)
    {
        $file = storage_path('app/public/invoice/' . $invoice_number . '.pdf');

        if (!file_exists($file)) {
            $return = redirect()->back()->with('error', 'File not found!');
        } else {
            $return = response()->download($file);
        }

        return $return;
    }
}
