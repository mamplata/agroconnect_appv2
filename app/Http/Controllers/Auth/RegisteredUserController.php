<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.manage-users', compact('users'));
    }

    public function create()
    {
        // Return the view for adding a new user
        return view('admin.add-user');
    }


    public function toggleStatus($userId)
    {
        $user = User::find($userId);

        if ($user) {
            // Toggle status (1 = Active, 0 = Inactive)
            $user->status = !$user->status;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => $user->status ? 'User activated' : 'User deactivated',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found',
        ]);
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
        ], [
            'password.regex' => 'Password must contain both letters and numbers.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            // Flash success message
            session()->flash('status', 'User created successfully!');
            session()->flash('status_type', 'success');  // status_type to distinguish success or error

            // Redirect to admin.manage-users route if user is successfully created
            return redirect()->route('admin.manage-users');
        } catch (\Exception $e) {
            // Flash error message
            session()->flash('status', 'An error occurred while creating the user.');
            session()->flash('status_type', 'error');

            // Stay on admin.add-user page in case of error
            return redirect()->route('admin.add-user')->withInput();
        }
    }
}
