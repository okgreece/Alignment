<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alignment:createSuperAdmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Super Admin User';

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
        echo "Create a Super Admin User\n";
        $name = $this->ask('Enter a name for the Super Admin User', 'admin');
        $email = $this->ask('Enter an email for the Super Admin User', 'admin@admin.com');
        $count = 0;
        $limit = 3;
        do {
            if ($count !== 0) {
                $this->error("\n\nError:");
                $this->error('Your passwords do not match. You have '.($limit - $count)." more tries...\n\n\n");
            }
            $password = $this->secret('Enter a password');
            $passwordRetype = $this->secret('Retype your password');
            $count++;
        } while ($password !== $passwordRetype && $count < 3);
        if ($count >= $limit) {
            $this->error("\n\nError:");
            $this->error("Could not create user. Password tries exceeded limit.\n\n\n");

            return;
        } else {
            $user = new \App\User();
            $user->name = $name;
            $user->password = bcrypt($password);
            $user->email = $email;
            $user->avatar = asset('/img/avatar04.png');
            $user->save();
            $this->info('User successfully created. Got to '.env('APP_URL').'/admin'.' to access the admin panel');
        }
    }
}
