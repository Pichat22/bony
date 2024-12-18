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
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        
        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
             'role' => 'client', // Rôle par défaut
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'admin') {
         return redirect()->intended(route('dashboard.index'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function updateRole(Request $request, $id)
{
    $request->validate([
        'role' => 'required|in:client,admin', // Validation pour éviter les rôles invalides
    ]);

    $user = User::findOrFail($id);
    $user->role = $request->role;
    $user->save();

    return redirect()->route('users.index')->with('success', 'Rôle mis à jour avec succès.');
}
public function allusers()
{
    $users = User::all();
    return view('users.index', compact('users'));

}
public function editRole($id)
{
    $user = User::findOrFail($id);
    return view('users.edit', compact('user'));


}
}