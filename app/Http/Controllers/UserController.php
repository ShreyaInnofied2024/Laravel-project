<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $data['password'] = Hash::make($data['password']);
            $data['user_role'] = 'customer';

            User::create($data);

            return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
        }

        return view('user.register');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt($data)) {
                $request->session()->regenerate();

                return redirect()->intended(route('home'));
            }

            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }

        return view('user.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6|confirmed',
            ]);

            if (!Hash::check($data['current_password'], Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            // Auth::user()->update(['password' => Hash::make($data['new_password'])]);

            return redirect()->route('dashboard')->with('success', 'Password changed successfully.');
        }

        return view('user.change_password');
    }

    public function manageAddresses()
    {
        $addresses = Auth::user()->addresses;

        return view('user.addresses', compact('addresses'));
    }

    public function addAddress(Request $request)
    {
        $data = $request->validate([
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $fullAddress = "{$data['line1']}";
        if (!empty($data['line2'])) {
            $fullAddress .= ", {$data['line2']}";
        }
        $fullAddress .= ", {$data['city']}, {$data['state']}, {$data['zip']}, {$data['country']}";

        // Auth::user()->addresses()->create(['address' => $fullAddress]);

        return back()->with('success', 'Address added successfully!');
    }

    public function deleteAddress($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $address->delete();

        return back()->with('success', 'Address deleted successfully!');
    }

    public function editAddress(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'line1' => 'required|string|max:255',
                'line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'zip' => 'required|string|max:20',
                'country' => 'required|string|max:100',
            ]);

            $fullAddress = "{$data['line1']}";
            if (!empty($data['line2'])) {
                $fullAddress .= ", {$data['line2']}";
            }
            $fullAddress .= ", {$data['city']}, {$data['state']}, {$data['zip']}, {$data['country']}";

            $address->update(['address' => $fullAddress]);

            return redirect()->route('user.addresses')->with('success', 'Address updated successfully.');
        }

        return view('user.edit_address', compact('address'));
    }

    public function listUsers()
    {
        $users = User::where('user_role', 'Customer')->get(); // Fetch all users
        return view('user.list', compact('users')); // Pass users to the view
    }
}

