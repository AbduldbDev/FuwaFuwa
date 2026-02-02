<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\OneTimePasswordMail;

class AuthService
{   
    public function createAccount(array $data): User
    {
        $otp = $this->generateStrongPassword();
        $data['password'] = Hash::make($otp);
        $data['otp'] = $otp;
        $user = User::create($data);
        Mail::to($user->email)->send(new OneTimePasswordMail($user));

        return $user;
    }
    
    public function login(array $credentials): void
    {
        $remember = $credentials['remember'] ?? false;
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email or password.',
            ]);
        }

        if ($user->must_reset_password) {
            if ($credentials['password'] !== $user->otp) {
                throw ValidationException::withMessages([
                    'email' => 'Invalid One Time Password.',
                ]);
            }

            session(['first_login_user_id' => $user->id]);
            redirect()->route('password.reset.first')->send();
            return;
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email or password.',
            ]);
        }

        Auth::login($user, $remember);
        request()->session()->regenerate();
    }

    public function getUserFromSession($sessionKey = 'first_login_user_id'): ?User
    {
        $userId = session($sessionKey);

        if (!$userId) {
            return null;
        }

        return User::find($userId);
    }

    public function resetPassword(User $user, string $password, $sessionKey = 'first_login_user_id'): void
    {
        $user->password = Hash::make($password);
        $user->must_reset_password = false;
        $user->otp = null;
        $user->save();

        Auth::login($user);
        session()->forget($sessionKey);
    }

    public function updateAccount(array $data, int $id): User
    {
        return DB::transaction(function () use ($data, $id) {
            $user = User::findOrFail($id);
            $user->update([
                'employee_id' => $data['employee_id'] ?? $user->employee_id,
                'department'  => $data['department']  ?? $user->department,
                'name'        => $data['name']        ?? $user->name,
                'username'    => $data['username']    ?? $user->username,
                'status'      => $data['status']      ?? $user->status,
                'user_type'   => $data['user_type']   ?? $user->user_type,
            ]);
            return $user;
        });
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
