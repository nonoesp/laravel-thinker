<?php

Route::get('/thinker', function() {
	return 'Hello, I am a thinker. Name: '.Config::get('profile.name');
});