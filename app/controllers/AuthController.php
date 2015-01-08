<?php

class AuthController extends Controller {

    public function showLogin() {
        return View::make('login');
    }

    public function authenticate() {

        //validate input
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            //bad input
            return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
        }

        //attempt to authenticate
        $email = Input::get('email');
        $password = Input::get('password');
        $remember = Input::get('remember', false);
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return Redirect::intended('dashboard');
        } else {
            //authentication failed
            return Redirect::route('login')->withErrors(array('email' => 'authentication failed'))->withInput(Input::except('password'));
        }
    }

    public function logout() {

        Auth::logout();
        return Redirect::route('dashboard');
    }
}