<?php

namespace App\Repositories;

use Cache;
use Carbon\Carbon;

class ColourRepository
{
    CONST CACHE_NAME = 'colours';

    /**
     * Returns an array of hex colour codes.
     * 
     * @return array
     */
    public function get()
    {
        $expire = Carbon::now()->addHours(8);

        return Cache::remember(self::CACHE_NAME, $expire, function() {
            $colours = [
                '#23bddc',
                '#2296dd',
                '#217fde',
                '#2461db',
                '#4a25da',
                '#7a21de',
                '#9a1de2',
                '#b11ee1',
            ];

            return $colours;
        });
    }
}