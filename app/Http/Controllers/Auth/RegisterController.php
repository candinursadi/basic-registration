<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

    public function showRegistrationForm()
    {
        if (request()->ajax()) {
            $users = User::query();
            return datatables()->of($users)
                ->addIndexColumn()
                ->make();
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validate = $this->validator($request->all());

        if($validate->fails()){
            $errorString = implode("<br>",$validate->messages()->all());
            alert()->html('Failed', $errorString, 'warning')->persistent(true);
            $validate->validate();
        }

        $user = $this->create($request->all());

        alert()->success('Success', "Registration successfully")->persistent(true);

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect()->back();
    }

    public function registerDelete(Request $request)
    {
        $user = User::find($request->id);

        if($user->delete()) $response['status'] = true;
        else $response['success'] = false;

        return response()->json($response);
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
            'hobby' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'regex:/08[1-9][0-9]{7}/', 'digits_between:10,13'],
            'username' => ['required', 'string', 'max:10', 'unique:users'],
            'password' => ['required', 'string', 'min:7', 'confirmed'],
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
        return User::create([
            'name' => ucwords($data['name']),
            'hobby' => $data['hobby'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
