<?php 

namespace Fin\Validation\Forms;
use Respect\Validation\Validator as vx;

class OrderValidation 
{
    public static function rules()
    {
        return [
            'email'=>vx::email(),
            'names'=>vx::alpha(' '),
            'address'=>vx::alnum(' -'),
            'phone'=>vx::numeric(),
            'city'=>vx::alnum(' '),
        ];
    }
}