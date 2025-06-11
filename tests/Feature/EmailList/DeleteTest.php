<?php

namespace Tests\Feature\Feature\EmailList;

use App\Models\EmailList;
use App\Models\Subscriber;
use function Pest\Laravel\delete;
use function Pest\Laravel\assertSoftDeleted;

it('it should be able to delete an email list', function () {
    // arrange
    login();
    $emailList = EmailList::factory()->create();
    $subscribers = Subscriber::factory()->count(10)->create(['email_list_id' => $emailList->id]);

    // act
    $response = delete(route('email-list.delete', ['emailList' => $emailList]));

    // assert
    assertSoftDeleted('email_lists', ['id' => $emailList->id]);
    foreach ($subscribers as $subscriber) {
        assertSoftDeleted('subscribers', ['id' => $subscriber->id]);
    }
});
