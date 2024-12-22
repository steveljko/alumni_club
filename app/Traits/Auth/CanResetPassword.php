<?php

namespace App\Traits\Auth;

use App\Exceptions\ToastExpcetion;
use App\Mail\Auth\SendPasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

// TODO: Test this trait
trait CanResetPassword
{
    /**
     * The duration (in minutes) for which the recovery token is valid.
     * After this period, the token will be considered expired and
     * cannot be used for password reset.
     */
    const TOKEN_EXPIRATION_MINUTES = 15;

    /**
     * The minimum duration (in minutes) that must pass after a password
     * reset request before another request can be made.
     */
    const MINUTES_AFTER_NEXT_REQUEST = 10;

    /**
     * Generates token and sends mail to user.
     */
    public function getPasswordRecoveryMail()
    {
        if ($this->isTokenRecentlyGenerated()) {
            throw new ToastExpcetion('You can only request a password reset once every 10 minutes.');
        }

        $token = $this->generateRecoveryToken();
        $link = route('reset_password', ['token' => $token]);

        Mail::to($this->email)->send(new SendPasswordReset($link));
    }

    /**
     * Checks if the recovery token for password reset is expired.
     */
    public function isRecoveryTokenExpired(): bool
    {
        if (! $this->password_reset_token_generated_at) {
            return true;
        }

        $expirationTime = Carbon::parse($this->password_reset_token_generated_at)
            ->addMinutes(self::TOKEN_EXPIRATION_MINUTES);

        return now()->greaterThan($expirationTime);
    }

    /**
     * Used for reseting token and generation time
     * for testing purposes.
     */
    public function resetPasswordRecovery(): void
    {
        $this->password_reset_token = null;
        $this->password_reset_token_generated_at = null;
        $this->save();
    }

    /**
     * Check if the password reset token was generated recently,
     * based on 'password_reset_token_generated_at' field.
     */
    private function isTokenRecentlyGenerated(): bool
    {
        return $this->password_reset_token_generated_at &&
          Carbon::parse($this->password_reset_token_generated_at)->greaterThan(now()->subMinutes(self::MINUTES_AFTER_NEXT_REQUEST));
    }

    /**
     * Generate recovery token and saves into row.
     */
    private function generateRecoveryToken(): string
    {
        $this->password_reset_token = Str::random(32);
        $this->password_reset_token_generated_at = now();
        $this->save();

        return $this->password_reset_token;
    }
}
