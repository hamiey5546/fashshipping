<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fashshipping:make-admin {email} {--password=}', function () {
    $email = strtolower(trim($this->argument('email')));
    $password = $this->option('password') ?: Str::password(16);

    $user = User::query()->updateOrCreate(
        ['email' => $email],
        ['name' => 'Admin', 'password' => Hash::make($password), 'role' => 'admin']
    );

    $this->info('Admin ready: '.$user->email);

    if (! $this->option('password')) {
        $this->line('Generated password: '.$password);
    }
})->purpose('Create or update an admin user for FashShipping');
