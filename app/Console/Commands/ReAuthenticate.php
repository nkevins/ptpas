<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ReAuthenticate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '2fa:reauthenticate {--username= : The username of the user to reauthenticate} {--force : run without asking for confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate the secret key for a user\'s two factor authentication';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // retrieve the username from the option
        $username = $this->option('username');

        // if no username was passed to the option, prompt the user to enter the username
        if (!$username) $username = $this->ask('what is the user\'s username?');

        // retrieve the user with the specified email
        $user = User::where('username', $username)->first();

        if (!$user) {
            // show an error and exist if the user does not exist
            $this->error('No user with that username.');
            return;
        }

        // Print a warning 
        $this->info('A new secret will be generated for '.$user->username);
        $this->info('This action will invalidate the previous secret key.');

        // ask for confirmation if not forced
        if (!$this->option('force') && !$this->confirm('Do you wish to continue?')) return;

        // initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // generate a new secret key for the user
        $user->google2fa_secret = $google2fa->generateSecretKey();

        // save the user
        $user->save();

        // show the new secret key
        $this->info('A new secret has been generated for '.$user->username);
        $this->info('The new secret is: '.$user->google2fa_secret);
    }
}
