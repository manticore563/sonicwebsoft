<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Butschster\Head\Facades\Meta;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\RegisterRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $data = ['name' => null, 'username' => null];
        if ($request->get('token', false)) {
            $token = json_decode(base64_decode($request->get('token')), true);
            $data['name'] = $token['name'] ?? null;
            $data['username'] = $token['username'] ?? null;
        }

        $meta = __("static_pages.register");
        Meta::setMeta((object) $meta);

        return view('auth.register', compact('data'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => true,
        ]);

        $default_role = setting('public_user_role', false);
        if ($default_role) {
            $role = Role::find($default_role);
            if ($role) {
                $user->assignRole($role);
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
