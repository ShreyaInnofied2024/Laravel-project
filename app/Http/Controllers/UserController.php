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
    
                // Check if there is an intended product ID in the session
                $intendedProductId = session()->pull('intended_product_id'); // Get and remove the value from the session
    
                if ($intendedProductId) {
                    // Redirect to add the product to the cart
                    return redirect()->route('cart.add', ['product_id' => $intendedProductId]);
                }

                if (Auth::user()->user_role === 'admin') { // Assuming your User model has 'is_admin' attribute
                    return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
                }
    
                // Redirect to the intended route or home page
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

    public function showChangePasswordForm($email)
    {
        return view('user.password', ['email' => $email]);
    }

    public function changePassword(Request $request, $email)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed', // Use `confirmed` to ensure password confirmation
        ]);

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login')->with('success', 'Password changed successfully!');
        }

        return back()->withErrors(['email' => 'User not found.']);
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
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $fullAddress = "{$data['line1']}";
        $fullAddress .= ", {$data['city']}, {$data['state']}, {$data['zip']}, {$data['country']}";

        Auth::user()->addresses()->create(['address' => $fullAddress]);

        return back()->with('success', 'Address added successfully!');
    }
    public function showAddresses()
    {
        $userId = auth()->id(); // Get the logged-in user's ID
        $addresses = Address::where('user_id', $userId)->get(); // Fetch addresses for the user

        return view('orders.index', compact('addresses'));
    }
    public function updateAddress(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'line1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        // Fetch the address and ensure it belongs to the authenticated user
        $address = Address::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Update the address field
        $address->update([
            'address' => implode(', ', [
                $validated['line1'],
                $validated['city'],
                $validated['state'],
                $validated['zip'],
                $validated['country'],
            ]),
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Address updated successfully!');
    }

    public function deleteAddress($id)
    {
        // Ensure the address belongs to the authenticated user
        $address = Address::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Delete the address
        $address->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Address deleted successfully!');
    }




    public function listUsers()
    {
        $users = User::where('user_role', 'Customer')->get(); // Fetch all users
        return view('user.list', compact('users')); // Pass users to the view
    }

    public function destroy($id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Delete the user
            $user->delete();

            // Redirect with success message
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Handle exceptions (e.g., user not found, database issues)
            return redirect()->route('users.list')->with('error', 'Failed to delete user. Please try again.');
        }
    }
}
