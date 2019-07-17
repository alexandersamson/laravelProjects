<?php

use App\RegistrationKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RegistrationKeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registrationKeys = [
            [
                'name' => 'DFA Samson',
                'user_email' => 'info@detectiveforall.nl',
                'user_permission' => 511,
                'regkey' => Hash::make(123456),
                'creator_id' => 1,
                'modifier_id' => 1
            ],
        ];
        foreach($registrationKeys as $rK){
            RegistrationKey::create($rK);
        }
    }
}
