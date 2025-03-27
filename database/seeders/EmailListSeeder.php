<?php

namespace Database\Seeders;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailList::factory()->count(10)->create()
        ->each(function (EmailList $list) {
            Subscriber::factory()->count(rand(10, 60))->create(['email_list_id' => $list->id]);
        });
    }
}
