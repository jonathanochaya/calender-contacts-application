<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'birthday' => ['required'],
            'company' => ['required']
        ]);

        Contact::create($data);
    }

    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }
}
