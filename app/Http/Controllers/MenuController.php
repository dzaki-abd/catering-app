<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // $units = Units::all();
            // return datatables()->of($units)
            //     ->addIndexColumn()
            //     ->addColumn('action', function ($row) {
            //         $btn = '<div class="d-flex justify-content-center align-items-center">';
            //         $btn .= '<a href="' . route('units.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
            //         $btn .= '<a href="' . route('units.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
            //         $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
            //         $btn .= '</div>';
            //         return $btn;
            //     })
            //     ->rawColumns(['action'])
            //     ->make(true);
        } else {
            return view('merchant.menu.index');
        }
    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
