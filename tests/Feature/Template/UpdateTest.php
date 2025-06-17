<?php

use App\Models\Template;

use function Pest\Laravel\Put;
use function Pest\Laravel\assertDatabaseHas;

pest()->group('template');

beforeEach(function () {
    login();

    $this->template = Template::factory()->create([
        'name' => 'Template Teste',
        'body' => '<span>Hello World!</span>'
    ]);
    $this->route = route('templates.update', $this->template);
});

it('should be able to update a template', function() {
    put($this->route, ['name' => 'Changing Template', 'body' => '<span>Has Changed</span>'])
        ->assertRedirect()
        ->assertSessionHas('message', __('Template successfully updated!'));

    assertDatabaseHas('templates', [
        'id' => $this->template->id,
        'name' => 'Changing Template',
        'body' => '<span>Has Changed</span>',
    ]);
});

test('name should be required', function() {
    put($this->route, ['name' => null, 'body' => '<span>Hello World!</span>'])
        ->assertSessionHasErrors(['name' => __('validation.required', ['attribute' => 'name'])]);
});

test('name should have a max of 255 character', function() {
    put($this->route, ['name' => str_repeat('*', 256), 'body' => '<span>Hello World!</span>'])
    ->assertSessionHasErrors(['name' => __('validation.max.string', ['attribute' => 'name', 'max' => 255])]);
});

test('body should be required', function() {
    put($this->route, ['name' => null, 'body' => null])
        ->assertSessionHasErrors(['body' => __('validation.required', ['attribute' => 'body'])]);
});
