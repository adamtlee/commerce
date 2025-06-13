<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateApiToken extends Command
{
    protected $signature = 'api:token {email}';
    protected $description = 'Create an API token for a user';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        $token = $user->createToken('api-token')->plainTextToken;
        $this->info("API Token created successfully:");
        $this->info($token);
        $this->info("\nUse this token in your requests with the header:");
        $this->info("Authorization: Bearer {$token}");

        return 0;
    }
} 