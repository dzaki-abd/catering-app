<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Merchant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            if ($request->merchant != null && $request->type == null) {
                $merchant = Merchant::where('name', $request->merchant)->first();
                $menus = Menu::where('merchant_id', $merchant->id)->get();
            } else if ($request->merchant == null && $request->type != null) {
                $menus = Menu::where('type', $request->type)->get();
            } else if ($request->merchant != null && $request->type != null) {
                $merchant = Merchant::where('name', $request->merchant)->first();
                $menus = Menu::where('merchant_id', $merchant->id)->where('type', $request->type)->get();
            } else {
                $menus = Menu::all();
            }

            return datatables()->of($menus)
                ->addIndexColumn()
                ->addColumn('merchant', function ($row) {
                    $merchant = $row->merchant->name ?? '-';
                    return $merchant;
                })
                ->addColumn('price', function ($row) {
                    $price = 'Rp ' . number_format($row->price, 0, ',', '.');
                    return $price;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<button class="view btn btn-info btn-sm me-2" title="See Details" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
                    $btn .= '<button data-id="' . encrypt($row->id) . '" class="btn btn-success btn-sm me-2" title="Add to Cart" data-toggle="modal" data-target="#addToCartModal"><i class="fas fa-shopping-cart"></i></button>';
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

    public function addToCart(Request $request, $id)
    {
        dd($request->all());
        $cart = \Cart::session(auth()->id());

        $menu = Menu::findOrFail(decrypt($id));

        $cart->add($menu->id, $menu->name, $menu->price, $request->qty, [
            'merchant' => $menu->merchant->name,
            'merchant_id' => $menu->merchant->id,
            'type' => $menu->type,
            'image' => $menu->image
        ]);

        return redirect()->back()->with('cart-success', 'Menu berhasil ditambahkan ke keranjang');
    }
}
