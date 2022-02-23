<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Membership;
use App\Models\User;
use DB;

class GuiaController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }  

    public function index()
    {
    	// Conseguir usuario identificado
		$user = \Auth::user();
		$id = $user->id;

    	// Total comission del usuario 
		$totalCommission = $this->totalCommission();

		// Total usuarios
		$totalusers = $totalusers = $this->countUsers();

		return view('guias.index', compact('user', 'totalusers', 'totalCommission'));
    }

    private function countUsers()
    {
      // Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;

      // Total usuarios
      $totalusers = DB::table('users')
            ->where('ownerId', $id)->count();

      return $totalusers;
    }

    private function totalCommission()
    {
      // Conseguir usuario identificado
      $user = \Auth::user();
      $id = $user->id;

      // Total usuarios
      $totalCommission = DB::table("network_transactions")
      ->where('user', $id)
      ->get()->sum("value");

      return $totalCommission;
    }
}
