<?php
session_start();

use App\Models\User;
use App\Models\UserRole;
use App\Models\ValidateQuestion;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
    'answer' => '',
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    DB::transaction(function () {
        $check = ValidateQuestion::where('answer', $this->answer)->exists();

if(!$check){

    // $_SESSION['error'] = 'Error';
    return ;
}
        $validated = $this->validate();

        $validated['password'] = Hash::make($validated['password']);

        // Create the user
        $user = User::create($validated);

        // Create a UserRole record with the newly created user
        // Assume you have a default role_id to assign. For example, 1 might be the default role ID.
        $roleId = 5; // Adjust this according to your application's role logic
        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $roleId,
        ]);

    // Fire the Registered event

    event(new Registered($user));

    // event(new Registered(($user = User::create($validated))));

    Auth::login($user);

     $this->redirect(RouteServiceProvider::HOME, navigate: true);

    });



};

?>

<div>
    {{-- @if(session('error'))
        <span>{{ session('error')}}</span>
    @endif --}}

    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Verify Code -->
        <div class="mt-4">
            <x-input-label for="answer" :value="__('Verify Code')" />
            <x-input wire:model="answer" id="answer" class="bock mt-1 w-full" type="text" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
