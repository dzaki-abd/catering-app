<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function addToCart(Request $request)
    {
        $cart = \Cart::session(auth()->id());

        $menu = Menu::findOrFail(decrypt($request->id));

        $cart->add($menu->id, $menu->name, $menu->price, $request->quantity, [
            'merchant' => $menu->merchant->name,
            'merchant_id' => encrypt($menu->merchant->id),
            'type' => $menu->type,
            'image' => $menu->image
        ]);

        return redirect()->back()->with('success', 'Menu added to cart successfully.');
    }

    public function cart()
    {
        $cart = \Cart::session(auth()->id())->getContent();
        $total = \Cart::session(auth()->id())->getTotal();

        return view('customer.order.cart', compact('cart', 'total'));
    }

    public function removeFromCart($id)
    {
        $cart = \Cart::session(auth()->id());
        $cart->remove($id);

        return redirect()->back()->with('success', 'Menu removed from cart successfully.');
    }

    public function checkout(Request $request)
    {
        $datetime = Carbon::createFromFormat('Y-m-d\TH:i', $request->date)->format('Y-m-d H:i:s');

        $cart = \Cart::session(auth()->id())->getContent();

        foreach ($cart as $item) {
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'merchant_id' => decrypt($item->attributes['merchant_id']),
                'menu_id' => $item->id,
                'quantity' => $item->quantity,
                'total' => $item->getPriceSum(),
                'delivery_date' => $datetime,
                'delivery_address' => $request->address,
                'total_price_transaction' => $request->total_price
            ]);
        }

        \Cart::session(auth()->id())->clear();

        return redirect()->route('customer.order.index')->with('success', 'Checkout successfully.');
    }
}
