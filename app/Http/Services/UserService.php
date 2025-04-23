<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Str;

class UserService
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function createUser($email)
    {
        $company = Company::firstOrCreate([
            'title' => "Company for $email"
        ]);
        $company->save();
        $user = null;

        if (!empty($company)) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $email,
                    "company_id" => $company->id,
                    'password' => bcrypt(Str::random(16))
                ]
            );
        }

        return $user;
    }

    public function checkUser($email)
    {
        return $this->userRepository->fetchUserByEmail($email);
    }


}
