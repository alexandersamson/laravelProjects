<?php

namespace App\Rules;

use App\RegistrationKey;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class checkRegkey implements Rule
{

    protected $email;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // here you get the hashed name stored in your database (?)
        $hashedRegkey = RegistrationKey::where('user_email', '=', $this->email)->first()->regkey;

        // next, you compare this with the received value.
        if ($hashedRegkey){
            return Hash::check($value, $hashedRegkey);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No matching Email/Registration Key found.';
    }
}
