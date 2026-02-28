<?php

namespace IslamAlsayed\Toasts\Facades;

use Illuminate\Support\Facades\Facade;

class ToastFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'toast';
    }
}
