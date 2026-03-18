<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    public function save(Request $request)
    {
        $user = getActiveUser();
        $user->sidebarPreference()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'menu_order' => $request->menu_order,
                'submenu_order' => $request->submenu_order,
            ]
        );

        return response()->json(['status' => 'success']);
    }

    public function getOrder()
    {
        $user = getActiveUser();
        $preference = $user->sidebarPreference;

        return response()->json([
            'status' => 'success',
            'data' => [
                'menu_order' => $preference->menu_order ?? [],
                'submenu_order' => $preference->submenu_order ?? [],
            ]
        ]);
    }

    public function reset()
    {
        $user = getActiveUser();
        $user->sidebarPreference()->delete();
        return redirect()->route('dashboard.index')->withSuccess(__('messages.type_updated_successfully', ['type' => __('main.sidebar')]));
    }
}
