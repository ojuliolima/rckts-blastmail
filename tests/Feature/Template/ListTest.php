<?php


use App\Models\Template;
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use Illuminate\Support\Facades\Auth;

pest()->group('template');

beforeEach(function() {
    login();
});

it('only logged users can access templates', function () {
    Auth::logout();
    getJson(route('templates.index'))
        ->assertUnauthorized();
});

it('should be possible see the entire list of templates', function () {
    Template::factory()->count(5)->create();
    
    get(route('templates.index'))
        ->assertViewHas('templates', function ($value) {
            expect($value)->count(5);

            return true;
        });
});

it('should be able to search a template by name', function () {
    Template::factory()->count(5)->create();
    $template = Template::factory()->create(['name' => 'Teste']);

    get(route('templates.index', ['search' => 'Teste']))
        ->assertViewHas('templates', function ($value) use ($template) {
            expect($value)->count(1);
            expect($value)->first()->id->toBe($template->id);
            return true;
        });
});

it('should be able to search by id', function () {
    Template::factory()->create([
        'name' => 'Modelo Teste',
    ]);

    $template = Template::factory()->create([
        'name' => 'Modelo Teste 2',
    ]);

    get(route('templates.index', ['search' => 2]))
    ->assertViewHas('templates', function ($value) use ($template) {
        expect($value)->count(1);
        expect($value)->first()->id->toBe($template->id);
        return true;
    });
});

it('should be able to show deleted records', function () {
    Template::factory()->create(['deleted_at' => now()]);
    Template::factory()->create([]);

    get(route('templates.index'))
        ->assertViewHas('templates', function ($value) {
            expect($value)->count(1);

            return true;
    });

    get(route('templates.index', ['withTrashed' => 1]))
        ->assertViewHas('templates', function ($value) {
            expect($value)->count(2);

            return true;
    });
});

it('should be paginated', function () {
    Template::factory()->count(30)->create([]);

    get(route('templates.index'))
        ->assertViewHas('templates', function ($value) {
            expect($value)->count(15);
            expect($value)->toBeInstanceOf(LengthAwarePaginator::class);

            return true;
    });
});