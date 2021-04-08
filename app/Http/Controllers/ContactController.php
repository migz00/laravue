<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Contact;

class ContactController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($user)
    {
        return Contact::get()->where('user_id', $user);
    }

    public function store(Request $request)
    {
        $newContact = new Contact;

        $newContact->user_id = $request->user['id'];
        $newContact->name = $request->contact['name'];
        $newContact->email = $request->contact['email'];
        $newContact->phone = $request->contact['phone'];

        $newContact->save();

        return($newContact);
    }
}
