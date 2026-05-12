<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'student_id_number' => ['required', 'numeric', 'digits:9', 'unique:students,student_id_number'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'course' => ['required', 'string', 'in:BSIT,BSCS,BSEMC'],
            'year_level' => ['required', 'integer', 'in:1,2,3,4'],
            'block' => ['required', 'string', 'regex:/^[A-Z]$/', 'size:1'],
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        // Create student profile
        Student::create([
            'user_id' => $user->id,
            'student_id_number' => $request->student_id_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'block' => $request->block,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('student.dashboard', absolute: false));
    }
}
