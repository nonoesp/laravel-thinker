<?php

namespace Nonoesp\Thinker;

use Route;

Route::get('thinker', ['middleware' => 'login', 'uses' => 'Nonoesp\Thinker\ThinkerController@getHome']);