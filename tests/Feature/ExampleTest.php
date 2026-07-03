<?php

test('the home route redirects to the affiches list', function () {
    $this->get('/')->assertRedirect(route('affiches.index'));
});

test('the affiches list responds successfully', function () {
    $this->get(route('affiches.index'))->assertOk();
});
