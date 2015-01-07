<?php

use Illuminate\Support\Facades\Facade;

class BlocktrailFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return "blocktrail";
    }
}