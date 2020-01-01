<?php


namespace App\Http\Controllers\Patterns;


class PropertyContainerController
{
    public function index()
    {
        $arr = [];

        if (isset($arr['first']['second'])) {
            $arr['first']['second'] = 1;
        } else {
            $arr['first']['second'] = 2;
        }

        dd($arr);
        return 'Tut';
    }

}
