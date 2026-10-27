<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile management page with separate forms for
     * Profile Details, Update Email, and Change Password.
     */
    public function index()
    {
        $user = Auth::user();

        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the administrator's name.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.string' => 'Name must be a valid text string.',
            'name.max' => 'Name cannot exceed 255 characters.',
        ]);

        $user->name = trim($validated['name']);
        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('profile_success', 'Personal profile name updated successfully!')
            ->with('success', 'Profile details updated successfully.');
    }

    /**
     * Update the administrator's email address with validation and duplicate prevention.
     */
    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ], [
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please provide a valid email format (e.g. name@example.com).',
            'email.unique' => 'This email address is already in use by another account.',
            'email.max' => 'Email address cannot exceed 255 characters.',
        ]);

        $newEmail = strtolower(trim($validated['email']));

        if ($user->email === $newEmail) {
            return redirect()->route('admin.profile.index')
                ->with('email_info', 'The email address is identical to your current email.');
        }

        $user->email = $newEmail;
        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('email_success', 'Email address updated successfully!')
            ->with('success', 'Email address updated successfully.');
    }

    /**
     * Change the administrator's password securely with hashing.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
            'password_confirmation' => ['required', 'string'],
        ], [
            'current_password.required' => 'Please enter your current password.',
            'password.required' => 'Please enter a new password.',
            'password.min' => 'The new password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match the new password.',
            'password.different' => 'The new password must be different from your current password.',
            'password_confirmation.required' => 'Please confirm your new password.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The provided current password does not match our records.',
            ])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('password_success', 'Password changed successfully! Keep your credentials safe.')
            ->with('success', 'Password changed successfully.');
    }
}
