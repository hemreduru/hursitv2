<?php

namespace App\Actions\Auth;

use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VerifyRecaptcha
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle(Request $request, $next)
    {
        // Only validate if 'g-recaptcha-response' is present, usually sent by frontend
        // Assuming admin login form includes it.

        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => ['required', new Recaptcha],
        ], [
            'g-recaptcha-response.required' => 'Please complete the ReCaptcha.',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->messages()->toArray());
        }

        return $next($request);
    }
}
