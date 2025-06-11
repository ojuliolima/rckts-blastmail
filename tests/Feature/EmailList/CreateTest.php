<?php

use Illuminate\Http\UploadedFile;

pest()->group('email-list');

beforeEach(function () {
    login();
});

test('it should be able create an email list', function () {
    //Arrage
    $data = [
        'title' => 'Email List Test',
        'file' => UploadedFile::fake()->createWithContent(
            'contacts.csv',
            <<<'CSV'
                Name,Email
                Joe Doe,joe@doe.com
                CSV
        ),
    ];

    //Act
    $request = $this->post(route('email-list.store'), $data);

    //Assert
    $request->assertRedirectToRoute('email-list.index');

    $this->assertDatabaseHas('email_lists', [
        'title' => 'Email List Test',
    ]);

    $this->assertDatabaseHas('subscribers', [
        'email_list_id' => 1,
        'name' => 'Joe Doe',
        'email' => 'joe@doe.com'
    ]);
});

test('title should be required', function () {
    $this->post(route('email-list.store'), [])
        ->assertSessionHasErrors(['title']);
});

test('file should be required', function () {
    $this->post(route('email-list.store'), [])
        ->assertSessionHasErrors(['file']);
});

test('title should be a max of 255 characters', function () {
    $this->post(route('email-list.store'), ['title' => str_repeat('*', 256)])
        ->assertSessionHasErrors(['title']);
});
