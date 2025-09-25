<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Defines a gate to check if the authenticated user can update a contact.
        Gate::define('update-contact', function ($user, $contact) {
            return $user->id == $contact->user_id;
        });

        //Defines a gate to check if the authenticated user can add a contact to a group.
        Gate::define('add-contact-to-group', function ($user, $contact, $group) {
            return $user->id == $contact->user_id && user->id == $group->user_id;
        });

        if (Gate::denies('add-contact-to-group', [$contact, $group])) {
            abort(403);
        }
    }
}
