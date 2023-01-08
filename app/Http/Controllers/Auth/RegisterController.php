<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        // dd($data);
        if($data['hidden']==1)
        {
            // $company= new Company();
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => 'company',
                'password' => Hash::make($data['password']),
            ]);
        }
        elseif  ($data['hidden']==2)
        {
            // $company= new Jobsearch();

            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => 'jobsearch',
                'password' => Hash::make($data['password']),
            ]);
        }

    }

    public function showRegistrationForm(Request $request)
    {

        if ($request->id == 1)
        {

            return view('company');
        }
        elseif($request->id == 2)
        {

            return view('registerjob');
        }
    }
}