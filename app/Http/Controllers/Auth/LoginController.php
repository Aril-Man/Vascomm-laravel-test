<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PassMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except(['logout', 'index']);
    }

    public function index()
    {
        if (Auth::user() != null) {
            if(Auth::user()->role == "admin"){
                return redirect()->route('admin.index');
            }else if(Auth::user()->role == "customer"){
                return redirect()->route("landing");
            }
        }
        return redirect()->route('landing');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        if($request->email){
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);

            $login = auth()->attempt(array('email' => $input['email'], 'password' => $input['password']));
            $wordingError = 'Email And Password Are Wrong.';
        } else{
            return redirect()->route('login')->with('error','Login Failed');
        }

        if (Auth::user() != null) {
            if (Auth::user()->role == "admin") {
                return redirect()->route('admin.index');
            }else if (Auth::user()->role == "customer"){
                return redirect()->route("landing");
            }
        }

        return redirect()->route('login')->with('error', $wordingError);
    }

    public function registerPage() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if ($validate->fails()) return redirect()->route('register')->with('error', $validate->errors()->first());

        $pass = fake()->password();
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = 'inactive';
        $user->role = 'customer';
        $user->password = Hash::make($pass);
        $user->save();

        $emailData = [
            'title' => 'Mail for send password',
            'name' => $request->name,
            'body' => 'your password is : ' . $pass,
        ];

        Mail::to($request->email)->send(new PassMail($emailData));

        return redirect()->route('login')->with('success', 'Success Register. Check your inbox email and wait for approve by admin');
    }

    public function logout()
    {
        if (Auth::user()->role == "admin") {
            auth()->logout();
            return redirect()->route('login');
        }else {
            auth()->logout();
            return redirect()->route('landing');
        }
    }
}
