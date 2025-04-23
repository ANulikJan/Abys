<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{

    public function createLinkToken($email, $token, $expiresAt)
    {
        DB::table('magic_links')->insert([
            'email' => $email,
            'token' => $token,
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function fetchUserByEmail($email)
    {
        return User::with('company')->where('email', $email)->first();
    }

    public function fetchUser($token)
    {
        return DB::table('magic_links')->where('token', $token)->first();
    }

    public function deleteToken($token)
    {
        return DB::table('magic_links')->where('token', $token)->delete();
    }

}
