<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\OneTimePasswordMail;
use Illuminate\Support\Arr;
use App\Services\NotificationService;

class UserService
{
    protected $notification;

    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    public function createAccount(array $data): User
    {
        $otp = $this->generateStrongPassword();
        $data['password'] = Hash::make($otp);
        $data['otp'] = $otp;

        $user = User::create($data);

        $this->notification->notifyUsersWithModuleAccess(
            'User',
            'write',
            'New User Created',
            "User " . $user->name . " has registered with the email " . $user->email . ".",
            'info'
        );

        Mail::to($user->email)->send(new OneTimePasswordMail($user));
        return $user;
    }

    public function updateAccount(array $data, User $user): User
    {
        $fillableData = Arr::only($data, $user->getFillable());
        $user->update($fillableData);

        $this->notification->notifyUsersWithModuleAccess(
            'User',
            'write',
            'New User Updated',
            "User " . $user->name . " has been updated by: " . Auth::user()->name . ".",
            'info'
        );

        return $user;
    }


    public function deleteAccount(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $user;
    }

    private function generateStrongPassword()
    {
        $length = 12;
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers   = '0123456789';
        $symbols   = '!@#$%^&*';

        $password = '';
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];


        $allChars = $lowercase . $uppercase . $numbers . $symbols;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        $password = str_shuffle($password);
        return $password;
    }
}
