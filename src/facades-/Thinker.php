<?php
namespace Nonoesp\Thinker\Facades;
use Illuminate\Support\Facades\Facade;
class Thinker extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'thinker'; }
    
}