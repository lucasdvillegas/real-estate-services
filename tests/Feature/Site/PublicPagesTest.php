<?php

test('home page renders', function () {
    $this->get(route('home'))->assertOk();
});

test('about page renders', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('Nosotros');
});
