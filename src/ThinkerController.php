<?php

namespace Nonoesp\Thinker;

use Illuminate\Http\Request;
use Arma\Http\Requests;
use Arma\Http\Controllers\Controller;
use View;

class ThinkerController extends Controller
{
    public function getHome() {
        return 'This content is visible if your are logged in. <a href="'.config('authenticate.exit').'">Exit</a>.';
    }
}
