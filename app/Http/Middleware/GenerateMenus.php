<?php

namespace App\Http\Middleware;

use Closure;
use App\CommonFunctionSet;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('MyNavBar', function ($menu) 
        {
            $menuset = CommonFunctionSet::get_menuitem();
            foreach ($menuset as $menuitem)
            {
                $menu->add($menuitem->name, ['route'  => ['rq.index', 'svcequip_type' => $menuitem->keyname]]);
            }
        });

        return $next($request);
    }
}
