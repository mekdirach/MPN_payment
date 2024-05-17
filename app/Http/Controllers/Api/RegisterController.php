<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Response;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\app_menu;
use App\Models\app_permission;
use App\Models\app_role;
use App\Models\app_role_menu;
use App\Models\app_role_permission;

class RegisterController extends BaseController
{

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        $input = new User();
        $input->is_active = true;
        $input->table_id = 6;
        $input->created_by = 1;
        $input->user_id = 123;
        $input->flow_transaksi_id = 13;
        $input->organisasi_id = 9;
        $input->flag_status_id = 9;
        $input->role_id = 9;
        $input->is_locked = false;
        $input->failed_count = 0;
        $input->name = $request->name;
        $input->email = $request->email;
        $input->email = bcrypt($password);
        $input->save();

        $success['token'] =  $input->createToken('MyApp')->plainTextToken;
        $success['name'] =  $input->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        // Coba untuk melakukan otentikasi
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/member/dashboard');
        } else {
            // Otentikasi gagal, periksa jenis kesalahan
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return redirect()->route('login')->with('email-error', 'Email tidak valid.');
            } elseif (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Pesan untuk kata sandi yang salah
                return redirect()->route('login')->with('password-error', 'Kata sandi salah.');
            }
        }

        /*
        $user = User::where([
            ['email', '=', $request->email],
            ['is_active', '=', true]
        ])->first();

        if ($user) {
            if ($user->flag_status_id == '9') {
                if (Hash::check($request->password, $user->password)) {
                    if (Session::has('email')) {
                        Session::forget('email');
                    }
                    Session::put($request->email, 0);
                    $applications = app_role::where('is_active', true)->orderBy('orders', 'ASC')->get();
                    if ($user->role) {
                        foreach ($applications as $applications) {
                            if ($applications->id) {
                            }
                        }
                    }
                } else {
                    $res = $this->configure_rate_limiting($request);
                    return redirect('login')->with($res);
                }
            }
        }
       if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where([
                ['email', '=', $request->email],
                ['isactive', '=', true]
            ])->first();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            //return $this->sendResponse($success, 'User login successfully.');

            return redirect()->intended('/member/dashboard');
        } else {

            return view('welcome');
        }
    }

    public function logino(Request $request)
    {  /*

        // Validasi input

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        // Mencoba melakukan login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Mendapatkan role pengguna
            $role = app_role::find($user->role_id);

            // Memeriksa apakah pengguna memiliki role yang valid
            if ($role) {
                // Mendapatkan menu dan permission berdasarkan role
                $roleMenus = app_role_menu::where('role_id', $role->id)->pluck('menu_id')->toArray();
                $rolePermissions = app_role_permission::where('role_id', $role->id)->pluck('permission_id')->toArray();

                // Mendapatkan menu dan permission yang diperbolehkan
                $allowedMenus = app_menu::whereIn('id', $roleMenus)->get();
                $allowedPermissions = app_permission::whereIn('id', $rolePermissions)->get();

                // Simpan menu dan permission dalam session
                Session::put('allowedMenus', $allowedMenus);
                Session::put('allowedPermissions', $allowedPermissions);

                // Redirect ke halaman yang sesuai setelah login
                return redirect()->intended('/member/dashboard');
            }
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return redirect()->back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);

        /*
        try {
            Session::forget('email');

            $messages = [
                'required' => ':attribute tidak boleh kosong',
                'captcha' => 'Captcha salah',
            ];

            $rules = [
                'email' => 'required|email',
                'password' => 'required',
                'captcha' => 'required|captcha'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->route('login')
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = User::where([
                ['email', '=', $request->email],
                ['is_active', '=', true]
            ])->first();

            if ($user) {
                $appMenus = app_menu::all();
                $appPermissions = app_permission::all();
                $appRoles = app_role::all();
                $appRoleMenus = app_role_menu::where('role_id', $user->role_id)->pluck('menu_id')->toArray();
                $appRolePermissions = app_role_permission::where('role_id', $user->role_id)->pluck('permission_id')->toArray();

                if ($user->status == '4' && Hash::check($request->password, $user->password)) {
                    if (Session::has('email')) {
                        Session::forget('email');
                    }
                    Session::put($request->email, 0);

                    $menus = $appMenus->filter(function ($appMenu) use ($appRoleMenus) {
                        return in_array($appMenu->id, $appRoleMenus);
                    });

                    $permissions = $appPermissions->filter(function ($appPermission) use ($appRolePermissions) {
                        return in_array($appPermission->id, $appRolePermissions);
                    });

                    $base_route_back = $this->routing($user->role->role_id);

                    session([
                        'status' => 200,
                        'description' => 'berhasil login!',
                        'user' => $user,
                        'role' => $user->role,
                        'menus' => $menus,
                        'permissions' => $permissions,
                        'base_route_back' => $base_route_back,
                    ]);

                    return redirect()->route($base_route_back)->with([
                        'message' => $base_route_back == '/member/dashboard' ? 'Maaf, user tersebut menggunakan role yang belum diberi handler!' : 'User berhasil login',
                        'alert-type' => $base_route_back == '/member/dashboard' ? 'danger' : 'success'
                    ]);
                } else {
                    $res = $this->configure_rate_limiting($request);
                    return redirect()->intended('/member/dashboard')->with($res);
                    //return redirect('login')->with($res);
                }
            } else {
                return redirect('/member/dashboard')->with(['message' => 'Data tidak ditemukan', 'alert-type' => 'danger']);
            }
        } catch (\Throwable $th) {
            return redirect('/member/dashboard')->with(['message' => 'Silakan login ulang', 'alert-type' => 'danger']);
        }

        */
    }

    public function relogin_login($data_user)
    {
        try {
            Session::forget('email');

            $user = User::where([
                ['email', '=', $data_user->email],
                ['isactive', '=', true]
            ])->first();

            if ($user) {
                $appMenus = app_menu::all();
                $appPermissions = app_permission::all();
                $appRoles = app_role::all();
                $appRoleMenus = app_role_menu::where('role_id', $user->role_id)->pluck('menu_id')->toArray();
                $appRolePermissions = app_role_permission::where('role_id', $user->role_id)->pluck('permission_id')->toArray();

                if ($user->status == '4' && Hash::check($data_user->password, $user->password)) {
                    if (Session::has('email')) {
                        Session::forget('email');
                    }
                    Session::put($data_user->email, 0);

                    $menus = $appMenus->filter(function ($appMenu) use ($appRoleMenus) {
                        return in_array($appMenu->id, $appRoleMenus);
                    });

                    $permissions = $appPermissions->filter(function ($appPermission) use ($appRolePermissions) {
                        return in_array($appPermission->id, $appRolePermissions);
                    });

                    $base_route_back = $this->routing($user->role->role_id);

                    session([
                        'status' => 200,
                        'description' => 'berhasil login!',
                        'user' => $user,
                        'role' => $user->role,
                        'menus' => $menus,
                        'permissions' => $permissions,
                        'base_route_back' => $base_route_back,
                    ]);

                    return redirect()->route($base_route_back)->with([
                        'message' => $base_route_back == '/member/dashboard' ? 'Maaf, user tersebut menggunakan role yang belum diberi handler!' : 'User berhasil login',
                        'alert-type' => $base_route_back == '/member/dashboard' ? 'danger' : 'success'
                    ]);
                } else {
                    $res = $this->configure_rate_limiting($data_user);
                    return redirect()->intended('/member/dashboard')->with($res);
                }
            } else {
                return redirect('/member/dashboard')->with(['message' => 'Data tidak ditemukan', 'alert-type' => 'danger']);
            }
        } catch (\Throwable $th) {
            return redirect('/member/dashboard')->with(['message' => 'Silakan login ulang', 'alert-type' => 'danger']);
        }
    }



    public function logout(Request $request)
    {


        $user = Auth::user();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
        //    / return $this->sendResponse($user, 'User Logout Berhasil');
    }



    public function pelimpahan()
    {
        $user = Auth::user();


        return view('pages.dashboard.pelimpahan.index', $user);
    }

    public function nomorsakti()
    {
        $user = Auth::user();


        return view('pages.dashboard.nomorsakti.index', $user);
    }
}
