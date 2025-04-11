<?php
namespace Arthurspar\Atomic\Core;

class Hooks
{
    public static function useState($initialValue)
    {
        $state = $initialValue;

        return [
            $state,
            function ($newValue) use (&$state) {
                $state = $newValue;
            }
        ];
    }
}