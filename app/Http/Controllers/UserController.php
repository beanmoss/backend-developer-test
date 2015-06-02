<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    use RestControllerTrait;

    const MODEL = 'App\Models\User';

    protected $validationRules = ['first_name' => 'required|max:100', 'last_name' => 'required|max:100', 'email' => 'required|email|unique:users,email|max:100', 'password' => 'required|max:100|min:5'];

    protected $path = '/user';

    protected function beforeUpdate($data)
    {
        $id = $data->id;
        $this->validationRules['email'] = 'required|email|max:100|unique:users,email,'.$id;
    }
}