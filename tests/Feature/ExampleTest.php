<?php

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('search page can be rendered', function () {
    $response = $this->get(route('search', ['q' => 'pramuka']));

    $response->assertOk();
});

test('home page includes latest news below achievements', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Berita Terbaru')
        ->assertSee('Pramuka Peduli Lingkungan Pantai');
});