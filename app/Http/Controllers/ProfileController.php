<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->roles->pluck('name')->first() == 'merchant') {
            $data = Merchant::where('user_id', $user->id)->first();
            $data->role = 'merchant';
            $id = encrypt($data->id);
        } else if ($user->roles->pluck('name')->first() == 'customer') {
            $data = Customer::where('user_id', $user->id)->first();
            $data->role = 'customer';
            $id = encrypt($data->id);
        } else {
            // $data = $user;
        }

        return view('profile', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $user = auth()->user();
        $id = decrypt($id);

        if ($user->roles->pluck('name')->first() == 'merchant') {
            $merchant = Merchant::find($id);
            $account = User::find($merchant->user_id);
            $update = $merchant->update($request->all());
        } else if ($user->roles->pluck('name')->first() == 'customer') {
            $customer = Customer::find($id);
            $account = User::find($customer->user_id);
            $update = $customer->update($request->all());
        } else {
            // $update = $user->update($request->all());
        }

        if ($update) {
            $account->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $return = redirect()->route('profile.index')->with('success', 'Profile updated successfully');
        } else {
            $return = redirect()->route('profile.index')->with('error', 'Profile failed to update');
        }

        return $return;
    }
}
