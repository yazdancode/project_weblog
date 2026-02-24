<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Services\MailService;
use App\User;
use System\Config\Config;
use System\Session\Session;

class ForgotController
{
    private $redirectTo = '/home';
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function view()
    {
        return view('auth.forgot');
    }

    public function forgot()
    {
        $forgotTime = $this->session->get('forgot.time');

        if ($forgotTime && $forgotTime > time()) {
            error('forgot', 'لطفاً ۲ دقیقه صبر کنید و دوباره تلاش کنید');
            return back();
        }
        $this->session->set('forgot.time', time() + 120);

        $request = new ForgotRequest();
        $inputs = $request->all();

        $user = User::where('email', $inputs['email'])->get();

        if (empty($user)) {
            error('forgot', 'کاربر وجود ندارد');
            return back();
        }
        $user = $user[0];
        $user->remember_token = generateToken();
        $user->remember_token_expire = date("Y-m-d H:i:s", strtotime('+10 minutes'));
        $user->save();
        $resetLink = route('auth.reset-password.view', [$user->remember_token]);

        $message = '
            <h2>ایمیل بازیابی رمز عبور</h2>
            <p>کاربر گرامی، برای بازیابی رمز عبور خود از لینک زیر استفاده نمایید:</p>
            <p style="text-align: center">
                <a href="' . $resetLink . '">بازیابی رمز عبور</a>
            </p>
        ';

        $mailService = new MailService();
        $mailService->send(
            $inputs['email'],
            'ایمیل بازیابی رمز عبور',
            $message
        );

        flash('forgot', 'ایمیل بازیابی با موفقیت ارسال شد');

        return redirect($this->redirectTo);
    }
}