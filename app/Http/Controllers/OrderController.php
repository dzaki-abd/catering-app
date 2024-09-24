<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Merchant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $menus = Menu::all();
            return datatables()->of($menus)
                ->addIndexColumn()
                ->addColumn('merchant', function ($row) {
                    $merchant = $row->merchant->name;
                    return $merchant;
                })
                ->addColumn('price', function ($row) {
                    $price = 'Rp ' . number_format($row->price, 0, ',', '.');
                    return $price;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<button data-id="' . encrypt($row->id) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="fas fa-eye"></i></button>';
                    $btn .= '<a href="' . route('merchant.menu.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="fas fa-edit"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['merchant', 'price', 'action'])
                ->make(true);
        } else {
            $merchant = Merchant::all();
            return view('customer.order.index', compact('merchant'));
        }
    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
