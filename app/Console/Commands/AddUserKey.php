<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class AddUserKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate user_key based on md5 encryption of email';

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
        $users = User::get();

        $bar = $this->output->createProgressBar(count($users));

        foreach ($users as $user) {
            if (!$user->user_key && !$user->firebase_uid) {
                $user->update([
                    'user_key' => md5($user->email)
                ]);
                $this->info(' - User : ' . $user->email . ' key generated');
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
