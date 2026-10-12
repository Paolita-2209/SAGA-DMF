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
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
   public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // jamais choisi par le visiteur
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('livres.index'));
    }
    public function show(User $user ): View
    {
        return view('', compact('user'));
    }

    public function edit(User $user, $id): View
    {
       $user = User::findorFail($id);
       return view('', compact('user'));
    }

    public function update(Request $request, User $user, $id)
    {
        $user = User::findorFail($id);

        $request->validate([
             'name' => 'require|string|max:255',
             'email' =>   'require|email|unique:users,email,$id', 
             'password' => 'required|current_password',
             'role' => 'required|in:admin,user',
        ]);

        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role'=> 'user',

      ]);

      

  }


    public function destroy(User $user,$id): RedirectResponse
    {
       $user = User::findOrFail($id)->delete();
        return redirect()->route('user')->with('success', 'Utilisateur supprimé.');
    }
}
