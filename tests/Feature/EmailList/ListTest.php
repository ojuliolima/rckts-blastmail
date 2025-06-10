<?php

namespace Tests\Feature\EmailList;

use Tests\TestCase;
use App\Models\User;
use App\Models\EmailList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ListTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function test_needs_to_be_authenticated()
    {
        Auth::logout();
        
        $this->getJson(route('email-list.index'))->assertUnauthorized();

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get(route('email-list.index'))->assertSuccessful();
    }
    public function test_it_should_be_paginate()
    {
        //arrange
        EmailList::factory()->count(40)->create();

        //act
        $response = $this->get(route('email-list.index'));

        //asset
        $response->assertViewHas('emailLists', function ($list) {
            $this->assertInstanceOf(LengthAwarePaginator::class, $list);
            $this->assertCount(5, $list);

            return true;
        });
    }

    public function test_it_should_be_able_to_search_a_list()
    {
        //arrange
        EmailList::factory()->count(10)->create();
        EmailList::factory()->create(['title' => 'Title 1']);
        $emailList = EmailList::factory()->create(['title' => 'Title Testing 2']);

        //act
        $response = $this->get(route('email-list.index', ['search' => 'Testing 2']));

        //asset
        $response->assertViewHas('emailLists', function ($list) use($emailList) {
            $this->assertInstanceOf(LengthAwarePaginator::class, $list);
            $this->assertCount(1, $list);
            $this->assertEquals($emailList->id, $list->first()->id);

            return true;
        });
    }
}