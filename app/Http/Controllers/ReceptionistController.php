<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
