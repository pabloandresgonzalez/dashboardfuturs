<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ConsultId extends Controller
{
    public function index()
    {
        return view('users.ConsultId');

    }

}
