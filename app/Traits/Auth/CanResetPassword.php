<?php

namespace App\Traits\Auth;

use App\Exceptions\ToastExpcetion;
use App\Mail\Auth\SendPasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

trait CanResetPassword
{
    /**
     * The duration (in minutes) for which the recovery token is valid.
     * After this period, the token will be considered expired and
     * cannot be used for password reset.
     */
    const TOKEN_TTL = 15;

    /**
     * The minimum duration (in minutes) that must pass after a password
     * reset request before another request can be made.
     */
    const MINUTES_BEFORE_NEXT_REQUEST = 10;

    /**
     * Generates a password recovery token and sends a reset email to the user.
     */
    public function sendPasswordRecoveryMail()
    {
        if ($this->canSubmitReqeust()) {
            throw new ToastExpcetion('You can only request a password reset once every 10 minutes.');
        }

        $token = $this->generateRecoveryToken();
        $link = route('reset_password', ['token' => $token]);

        Mail::to($this->email)
            ->send(new SendPasswordReset($link));
    }

    /*
     * Sets a new password for the user if the provided token is valid.
     */
    public function setNewPassword(string $password): bool
    {
        if (! $this->isTokenValid()) {
            throw new ToastExpcetion('Provided token is invalid!');
        }

        $this->password = Hash::make($password);

        $this->resetPasswordRecoveryFields();

        return $this->save();
    }

    /**
     * Verifies if the recovery token for password reset is expired.
     */
    public function isTokenValid(): bool
    {
        if (! $this->password_reset_token_generated_at) {
            return true;
        }

        $expirationTime = Carbon::parse($this->password_reset_token_generated_at)
            ->addMinutes(self::TOKEN_TTL);

        return now()->lessThanOrEqualTo($expirationTime);
    }

    /**
     * Checks if a new password reset request can be submitted.
     * This helps to avoid sending multiple reset emails in a short period of time.
     */
    private function canSubmitReqeust(): bool
    {
        return $this->password_reset_token_generated_at &&
          Carbon::parse($this->password_reset_token_generated_at)->greaterThan(now()->subMinutes(self::MINUTES_BEFORE_NEXT_REQUEST));
    }

    /**
     * Clears all fields related to the password reset process.
     */
    public function resetPasswordRecoveryFields(): void
    {
        $this->password_reset_token = null;
        $this->password_reset_token_generated_at = null;
    }

    /**
     * Creates a new recovery token and saves it to the database.
     */
    private function generateRecoveryToken(): string
    {
        $this->password_reset_token = Str::random(32);
        $this->password_reset_token_generated_at = now();
        $this->save();

        return $this->password_reset_token;
    }
}
