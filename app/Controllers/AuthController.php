<?php
namespace App\Controllers;
use App\Core\Request; use App\Core\Session; use App\Core\View; use App\Services\Auth;
final class AuthController {
    public function showLogin(Request $r): never { if(Auth::user()){header('Location: /dashboard');exit;} View::render('auth/login',['error'=>Session::flash('error')]); }
    public function login(Request $r): never { if(!Session::verifyCsrf($r->input('_token'))){http_response_code(419);exit('Permintaan kedaluwarsa.');} $email=filter_var($r->input('email'),FILTER_VALIDATE_EMAIL); if(!$email || !Auth::attempt($email,(string)$r->input('password'))){Session::flash('error','Email atau kata sandi tidak valid.');header('Location: /login');exit;} header('Location: /dashboard');exit; }
    public function logout(Request $r): never { if(!Session::verifyCsrf($r->input('_token'))){http_response_code(419);exit('Permintaan kedaluwarsa.');} Auth::logout();header('Location: /');exit; }
}
