<?php

use GrantHolle\Scru128Laravel\Concerns\HasScru128Ids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Schema;

class Post extends Model
{
    use HasScru128Ids;

    public $timestamps = false;

    protected $guarded = [];
}

beforeEach(function () {
    Schema::create('posts', function ($table) {
        $table->scru128();
        $table->string('title');
    });
});

it('creates the column via blueprint macros', function () {
    Schema::create('comments', function ($table) {
        $table->scru128();
        $table->foreignScru128('post_id')->constrained();
    });

    expect(Schema::getColumnType('comments', 'id'))->toBe('varchar')
        ->and(Schema::getColumnType('comments', 'post_id'))->toBe('varchar')
        ->and(collect(Schema::getForeignKeys('comments'))->pluck('foreign_table'))->toContain('posts')
        ->and(collect(Schema::getIndexes('comments'))->firstWhere('primary', true)['columns'])->toBe(['id']);
});

it('assigns a scru128 id on create', function () {
    $post = Post::create(['title' => 'Hello']);

    expect($post->id)->toMatch('/^[0-9a-z]{25}$/')
        ->and($post->getIncrementing())->toBeFalse()
        ->and($post->getKeyType())->toBe('string')
        ->and(Post::find($post->id)->title)->toBe('Hello');
});

it('generates sortable ids', function () {
    $a = Post::create(['title' => 'a']);
    $b = Post::create(['title' => 'b']);

    expect($a->id < $b->id)->toBeTrue();
});

it('keeps an explicitly set id', function () {
    $post = Post::create(['id' => '0372ijojuxuhjsfkeryi2mrtm', 'title' => 'x']);

    expect($post->id)->toBe('0372ijojuxuhjsfkeryi2mrtm');
});

it('resolves uppercase ids in route binding', function () {
    $post = Post::create(['title' => 'x']);

    expect((new Post)->resolveRouteBinding(strtoupper($post->id))->id)->toBe($post->id);
});

it('rejects invalid ids in route binding', function () {
    (new Post)->resolveRouteBinding('not-a-scru128');
})->throws(ModelNotFoundException::class);
