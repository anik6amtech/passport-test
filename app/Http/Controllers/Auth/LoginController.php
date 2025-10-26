<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle admin login
     */
    public function loginAdmin(Request $request)
    {
        return $this->handleLogin($request, 'admin');
    }

    /**
     * Handle customer login
     */
    public function loginCustomer(Request $request)
    {
        return $this->handleLogin($request, 'customer');
    }

    /**
     * Handle deliveryman login
     */
    public function loginDeliveryman(Request $request)
    {
        return $this->handleLogin($request, 'deliveryman');
    }

    /**
     * Handle supplier login
     */
    public function loginSupplier(Request $request)
    {
        return $this->handleLogin($request, 'supplier');
    }

    /**
     * Handle login for different user types
     */
    private function handleLogin(Request $request, $userType)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('user_type', $userType);
        }

        $credentials = $request->only('email', 'password');

        // For now, we'll use a simple authentication check
        // In a real application, you would check against different user tables
        // or add a user_type field to your users table

        if ($this->attemptLogin($credentials, $userType)) {
            $request->session()->regenerate();

            // Redirect based on user type
            return $this->redirectAfterLogin($userType);
        }

        return redirect()->back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput()
            ->with('user_type', $userType);
    }

    /**
     * Attempt to log the user in
     */
    private function attemptLogin($credentials, $userType)
    {
        // Find user by email and user_type
        $user = \App\Models\User::where('email', $credentials['email'])
                                ->where('user_type', $userType)
                                ->where('is_active', true)
                                ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Store user information in session
            session(['user_type' => $userType]);
            session(['user_email' => $credentials['email']]);
            session(['user_id' => $user->id]);
            session(['user_name' => $user->name]);
            return true;
        }

        return false;
    }

    /**
     * Redirect after successful login based on user type
     */
    private function redirectAfterLogin($userType)
    {
        switch ($userType) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'customer':
                return redirect()->route('customer.dashboard');
            case 'deliveryman':
                return redirect()->route('deliveryman.dashboard');
            case 'supplier':
                return redirect()->route('supplier.dashboard');
            default:
                return redirect('/');
        }
    }

    /**
     * Log the user out
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
