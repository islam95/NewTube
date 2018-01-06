<?php

namespace App\Http\ViewComposers;


use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


class NavigationComposer {

    public function compose(View $view){
        if (!Auth::check()){
            return;
        }
        $view->with('channel', Auth::user()->channel->first());
    }

}





