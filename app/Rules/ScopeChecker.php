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
        $defaultScopes = ['posting', 'active', 'owner', 'login'];
        $tmpScope = explode(',', $value);
        foreach($tmpScope as $k => $v) {
            if (!in_array($v, $defaultScopes)) {
                unset($tmpScope[$k]);
            }
        }
        if (count($tmpScope) == 0) {
            return false;
        }
        return true;
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
