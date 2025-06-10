<?php 

namespace Tests\Feature\EmailList;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class CreateTest extends TestCase {
    public function setUp(): void
    {
        parent::setUp();

        $this->login();
    }

    public function test_it_should_be_able_create_an_email_list()
    {
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
    }

    public function test_title_should_be_required()
    {

        $this->post(route('email-list.store'), [])
            ->assertSessionHasErrors(['title']);
    }

    public function test_file_should_be_required()
    {

        $this->post(route('email-list.store'), [])
            ->assertSessionHasErrors(['file']);
    }

    public function test_title_should_be_a_max_of_255_characters()
    {

        $this->post(route('email-list.store'), ['title' => str_repeat('*', 256)])
            ->assertSessionHasErrors(['title']);
    }
}