<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function infoContact()
    {
        $data = Auth::guard('client')->user();

        return response()->json([
            'data'   => $data,
        ]);
    }

    public function sendContact(Request $request)
    {
        $data = $request->all();
        Contact::create($data);

        return response()->json([
            'status'    => 1,
        ]);
    }
}
