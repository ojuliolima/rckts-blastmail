<?php

namespace Tests\Feature\Feature\EmailList;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_it_should_be_able_to_delete_an_email_list(): void
    {
        $this->login();
        $emailList = EmailList::factory()->create();
        $subscribers = Subscriber::factory()->count(10)->create(['email_list_id' => $emailList->id]);

        $response = $this->delete(route('email-list.delete', ['emailList' => $emailList]));

        $this->assertSoftDeleted('email_lists', ['id' => $emailList->id]);
        foreach ($subscribers as $subscriber) {
            $this->assertSoftDeleted('subscribers', ['id' => $subscriber->id]);
        }
    }
}
