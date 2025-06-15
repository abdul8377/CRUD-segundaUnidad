<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Lwwcas\LaravelCountries\Models\Country;

class RegisterController extends Controller
{
   public function show()
{
    app()->setLocale('es');

    $countries = DB::table('lc_countries')
        ->join('lc_countries_translations', 'lc_countries.id', '=', 'lc_countries_translations.lc_country_id')
        ->where('lc_countries_translations.locale', 'es')
        ->whereNotNull('lc_countries.iso_alpha_2')
        ->where('lc_countries.is_visible', true)
        ->orderBy('lc_countries_translations.name')
        ->pluck('lc_countries_translations.name', 'lc_countries.iso_alpha_2')
        ->toArray();

    return view('auth.register', compact('countries'));
}

function getFlagEmoji($iso)
{
    return mb_convert_encoding(
        '&#' . (127397 + ord($iso[0])) . '&#' . (127397 + ord($iso[1])),
        'UTF-8',
        'HTML-ENTITIES'
    );
}


    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user' => 'required|string|max:100|unique:users,user',
            'email' => 'required|string|email|max:255|unique:users,email',
            'country' => 'required|string|in:' . implode(',', Country::pluck('iso_alpha_2')->toArray()),
            'zip_code' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Asignar automáticamente el rol 'Usuario'
        $user->assignRole('Usuario');

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }

}
