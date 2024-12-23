<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\SysProfile;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function login()
    {
        $sysprofile = SysProfile::select('systitle', 'syslogo')->first();

        return view('auth.login', compact('sysprofile'));
    }

    public function loginProcess()
    {
        $recaptcha = request('g-recaptcha-response');
        $secret = env('CAPTCHA_SECRET_KEY');

        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $secret,
                'response' => $recaptcha
            ]
        ]);

        $result = json_decode($response->getBody()->getContents());

        if (!$result->success) {
            return redirect()->back()->with('error', 'Captcha verification failed');
        }

        // validate the request
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $data = [
            'email' => request('email'),
            'password' => request('password')
        ];

        $user = Users::select('users.*', 'group_path.landing_page')
            ->join('group_path', 'users.group_id', '=', 'group_path.id')
            ->where(['email' => $data['email'], 'status' => 1])
            ->first();
        $sysprofile = SysProfile::select('systitle', 'syslogo', 'sysname')->first();

        if ($user) {
            if (password_verify($data['password'], $user->password)) {
                session([
                    'id' => $user->id,
                    'group_id' => $user->group_id,
                    'expires_in' => time() + 3600,
                    'name' => $user->nama,
                    'systitle' => $sysprofile->systitle,
                    'syslogo' => $sysprofile->syslogo,
                    'sysname' => $sysprofile->sysname,
                    'isLoggedIn' => true
                ]);
                // update last login
                Users::where('id', $user->id)->update(['last_login' => date('Y-m-d H:i:s')]);

                return redirect()->to($user->landing_page);
            } else {
                return redirect()->back()->with('error', 'Email or password is incorrect');
            }
        } else {
            return redirect()->back()->with('error', 'Email tidak terdaftar, atau akun belum aktif');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('signin');
    }
}
