<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->registerResponseBindings();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
        // RateLimiter::for('two-factor', function (Request $request) {
        //     return Limit::perMinute(5)->by($request->session()->get('login.id'));
        // });
    }

    protected function registerResponseBindings() {
        //переопределяем юрл для восстановления пароля
        ResetPassword::createUrlUsing(function($notifiable, $token) {
            return url(env('SPA_URL'))."/auth/reset-password/{$token}?email={$notifiable->getEmailForPasswordReset()}";
        });
        //переопределяем юрл для подтверждения почты
        VerifyEmail::createUrlUsing(function($notifiable) {
            $id = $notifiable->getKey();
            $hash = sha1($notifiable->getEmailForVerification());
            $expires = Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60));
            $url = URL::temporarySignedRoute(
                'verification.verify',
                $expires,
                [
                    'id' => $id,
                    'hash' => $hash,
                ]
            );
            return env('SPA_URL').'/auth/verify/?id='.$id.'&hash='.$hash.'&'.parse_url($url)['query'];
        });
    }
}
