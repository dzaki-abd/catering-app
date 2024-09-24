<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $menus = Menu::where('merchant_id', auth()->user()->id)->get();
            return datatables()->of($menus)
                ->addIndexColumn()
                ->addColumn('price', function ($row) {
                    $price = 'Rp ' . number_format($row->price, 0, ',', '.');
                    return $price;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<a href="' . route('merchant.menu.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('merchant.menu.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="fas fa-edit"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="fas fa-trash-alt"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['price', 'action'])
                ->make(true);
        } else {
            return view('merchant.menu.index');
        }
    }

    public function create()
    {
        return view('merchant.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $image = $request->file('image');
            $image_name = 'Menu_' . auth()->user()->id . '_' . $request->name . '_' . time() . '.' . $image->extension();
            $image->move(public_path('images'), $image_name);
        } else {
            $image_name = null;
        }

        $price = str_replace('.', '', $request->price);

        $createMenu = Menu::create([
            'merchant_id' => auth()->user()->id,
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'image' => $image_name,
            'price' => $price,
        ]);

        if ($createMenu) {
            $return = redirect()->route('merchant.menu.index')->with('success', 'Menu created successfully.');
        } else {
            $return = redirect()->route('merchant.menu.index')->with('error', 'Menu failed to create.');
        }

        return $return;
    }

    public function show($id)
    {
        $data = Menu::find(decrypt($id));
        return view('merchant.menu.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Menu::find(decrypt($id));
        $id_enc = encrypt($data->id);
        return view('merchant.menu.edit', compact('data', 'id_enc'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
        ]);

        $menu = Menu::find(decrypt($id));

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $image = $request->file('image');
            $image_name = 'Menu_' . auth()->user()->id . '_' . $request->name . '_' . time() . '.' . $image->extension();
            $image->move(public_path('images'), $image_name);
            if ($menu->image) {
                unlink(public_path('images/' . $menu->image));
            }
        } else {
            $image_name = $menu->image;
        }

        $price = str_replace('.', '', $request->price);

        $updateMenu = $menu->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'image' => $image_name,
            'price' => $price,
        ]);

        if ($updateMenu) {
            $return = redirect()->route('merchant.menu.index')->with('success', 'Menu updated successfully.');
        } else {
            $return = redirect()->route('merchant.menu.index')->with('error', 'Menu failed to update.');
        }

        return $return;
    }

    public function destroy($id)
    {
        $menu = Menu::find(decrypt($id));
        if ($menu->image) {
            unlink(public_path('images/' . $menu->image));
        }
        $deleteMenu = $menu->delete();
        if ($deleteMenu) {
            $return = response()->json(['success' => 'Menu deleted successfully.']);
        } else {
            $return = response()->json(['error' => 'Menu failed to delete.']);
        }

        return $return;
    }
}
