<?php

namespace App\Console\Commands;

use App\Mail\SendCredentials;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ratchet\Wamp\Exception;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var string
     */
    private $stringChoiceVars;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->stringChoiceVars = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pass = substr($this->stringChoiceVars, 0, 10);

        $adminEmail = $this->validate_cmd(function() {
            return  $this->ask('Enter admin email please: ');
        }, ['email','required|email']);

        if ($this->confirm("Admin was created with {$adminEmail}. Continue?")) {
            DB::beginTransaction();

            $adminRole = Role::where('title', Role::DEFAULT_ADMIN_ROLE)->first();
            $userRole = Role::where('title', Role::DEFAULT_USER_ROLE)->first();
            try {

                $user = User::create([
                    'name' => 'admin',
                    'email' => $adminEmail,
                    'password' => Hash::make($pass)
                ]);

                $user->roles()->attach($adminRole);
                $user->roles()->attach($userRole);

                Mail::to($adminEmail)->send(new SendCredentials($adminEmail, $pass));
                DB::commit();

            } catch (Exception $exception) {
               $this->error($exception->getMessage());
               DB::rollBack();
            }

            $this->info('Admin successful created with email: ' . $adminEmail);
        }
    }

    /**
     * Validate an input.
     *
     * @param  mixed   $method
     * @param  array   $rules
     * @return string
     */
    public function validate_cmd($method, $rules)
    {
        $value = $method();
        $validate = $this->validateInput($rules, $value);

        if ($validate !== true) {
            $this->warn($validate);
            $value = $this->validate_cmd($method, $rules);
        }
        return $value;
    }

    public function validateInput($rules, $value)
    {

        $validator = Validator::make([$rules[0] => $value], [ $rules[0] => $rules[1] ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return $error->first($rules[0]);
        }else{
            return true;
        }

    }

}
