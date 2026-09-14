<?php

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('search page can be rendered', function () {
    $response = $this->get(route('search', ['q' => 'pramuka']));

    $response->assertOk();
});