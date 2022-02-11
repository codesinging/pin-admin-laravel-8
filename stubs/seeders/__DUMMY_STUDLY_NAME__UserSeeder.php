<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace __DUMMY_NAMESPACE__\Seeders;

use __DUMMY_NAMESPACE__\Models\__DUMMY_STUDLY_NAME__User;
use Illuminate\Database\Seeder;

class __DUMMY_STUDLY_NAME__UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        __DUMMY_STUDLY_NAME__User::create([
            'name' => '__DUMMY_NAME___user',
            'password' => 'pin.admin'
        ]);
    }
}
