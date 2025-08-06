<?php



namespace App\Http\Controllers;
use Spatie\Permission\Contracts\Role;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Commands\CacheReset;
class ReceptionistController extends Controller
{
     public function index()
    {
        if (Auth::check() && Auth::user()->getRoleNames()->first() == 'Receptionist') {
            return view('recp/recpHome');
        }

        return redirect()->route('login')->with('error', 'ليس لديك صلاحية الوصول إلى هذه الصفحة');
    }
}
