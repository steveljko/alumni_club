<?php

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Validator;

uses(TestCase::class);

it('validates base64 image size correctly', function () {
    $validImage = 'data:image/png;base64,'.base64_encode(str_repeat('a', 1024 * 1024)); // 1MB
    expect(Validator::make(['image' => $validImage], ['image' => 'base64_image_size:2048'])->passes())->toBeTrue();

    $oversizedImage = 'data:image/png;base64,'.base64_encode(str_repeat('a', 2048 * 1024)); // 2MB
    expect(Validator::make(['image' => $oversizedImage], ['image' => 'base64_image_size:2048'])->passes())->toBeFalse();
});

it('validates base64 image type correctly', function () {
    $validImage = 'data:image/png;base64,'.base64_encode('valid_image_content');
    expect(Validator::make(['image' => $validImage], ['image' => 'base64_image_type:jpeg,png'])->passes())->toBeTrue(); // valid type

    $invalidImage = 'data:image/gif;base64,'.base64_encode('invalid_image_content');
    expect(Validator::make(['image' => $invalidImage], ['image' => 'base64_image_type:jpeg,png'])->passes())->toBeFalse(); // invalid type
});
