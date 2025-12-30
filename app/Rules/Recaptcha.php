<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (!$response->successful()) {
            $fail('The recaptcha validation failed. Please try again.');
            return;
        }

        $body = $response->json();

        if (empty($body['success']) || !$body['success']) {
            $fail('Recaptcha validation failed.');
            return;
        }

        if (isset($body['score']) && $body['score'] < config('services.recaptcha.score', 0.5)) {
            $fail('Recaptcha score too low. Are you a robot?');
        }
    }
}
