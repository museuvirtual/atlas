<?php namespace App\Services;

use App\User;
use App\Collector;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
   /*
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
   */

    public function create(array $data)
    {
        $new_user= User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
//Automaticaly creates a collector for the new User
        //NAO ESTA A GRAVAR OS APELIDOS NEM O USER_ID...PKKKKK
        $new_collector = new Collector();

        $new_collector->name = $data['name'];
        $new_collector->surname = $data['surname'];
        if ($new_collector->save()){
            $new_user->collector_id=$new_collector->id;
            $new_user->save();
        }



        return $new_user;
    }

}
