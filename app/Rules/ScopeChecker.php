<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ScopeChecker implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $defaultScopes = ['posting', 'remove_posting', 'login'];
        if (in_array($value, $defaultScopes)) {
            return true;
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
        return '不支持的授权.';
    }
}
