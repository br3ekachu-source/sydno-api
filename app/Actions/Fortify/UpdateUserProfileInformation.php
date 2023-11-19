<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['string', 'max:255'],
            'phone_number' => ['max:20']
        ])->validateWithBag('updateProfileInformation');
        
        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            if (isset($input['name'])) {
                $user->name = $input['name'];
            }
            if (isset($input['phone_number'])) {
                $user->phone_number = $input['phone_number'];
            }
            $user->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        if (isset($input['name'])) {
            $user->name = $input['name'];
        }
        if (isset($input['phone_number'])) {
            $user->phone_number = $input['phone_number'];
        }
        $user->forceFill([
            'email_verified_at' => null
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
