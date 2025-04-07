<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        // Gate::guessPolicyNamesUsing(function (string $modelClass) {
        //     // Return the name of the policy class for the given model...
        //     // Logic to determine the policy class name based on the model class

        //     // Example: If your model namespace starts with "App\Models" in subdirectories named Backend,
        //     // and you have placed policies in within the "App\Policies" namespace,
        //     // you can use the following logic:

        //     $modelNamespace = 'App\Models\Backend\\';
        //     $policyNamespace = 'App\Policies';

        //     // Check if the model class belongs to the expected namespace
        //     if (strpos($modelClass, $modelNamespace) === 0) {
        //         // Extract the model name from the fully qualified class name
        //         $modelName = substr($modelClass, strlen($modelNamespace));
        //         //print_r($modelName);
        //         // Convert namespace separators to directory separators
        //         $policyName = str_replace('\\', '/', $modelName);

        //         // Construct the full policy class name
        //         $policyClass = $policyNamespace . '\\' . $policyName . 'Policy';

        //         //print_r($policyClass);
        //         print_r(class_exists($policyClass));
        //         // Check if the policy class exists
        //         if (class_exists($policyClass)) {

        //             print_r('I got here check if policy class exist');
        //             print_r($policyClass);
        //             return $policyClass;
        //         }
        //     }

        //     // If no custom logic matches, return null to fallback to default behavior
        //     return null;
        // });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            $first_name =  explode(" ", $notifiable->name)[0]; // Get first name

            return (new MailMessage)
                ->subject('Verification instructions for '.config('app.name'))
                ->greeting('Hi '.$first_name.',')
                ->line('Welcome to '.config('app.name').'.')
                ->line('Verify your email address by clicking the button below.')
                ->line('This link is only valid once')
                ->action('Verify Email Address', $url);
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $url) {
            $first_name =  explode(" ", $notifiable->name)[0]; // Get first name

            return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
                ->greeting('Hi '.$first_name.',')
                ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
                ->action(Lang::get('Reset Password'), $url)
                ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(Lang::get('If you did not request a password reset, no further action is required.'));
        });

    }
}
