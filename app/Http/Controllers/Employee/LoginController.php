<?php
namespace App\Http\Controllers\Employee;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

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

    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function username()
    {
        return 'email';
    }

    public function showLoginForm()
    {
        return view('employee.auth.login');
    }

    public function guard()
    {
        return Auth::guard('user');
    }

    public function login(Request $request)
    {
        $rememberMe = $request->remember ? true : false;
        $employee = Employee::where(['email' => $request->email])->first();
        if (!empty($employee) && Hash::check($request->password, $employee->password)) {
            Auth::guard('user')->login($employee, $rememberMe);
            return redirect()->intended('/home');
        }

        return back()->withInput()->withErrors(['Invalid Login Credential!']);
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        return redirect('/login');
    }
}
