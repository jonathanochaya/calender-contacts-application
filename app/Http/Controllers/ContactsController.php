<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function store()
    {
        Contact::create($this->validateData());
    }

    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    public function update(Contact $contact)
    {
        $contact->update($this->validateData());
    }

    public function validateData()
    {
        return request()->validate([
            'name' => ['sometimes', 'required', 'string'],
            'email' => ['sometimes', 'required', 'email'],
            'birthday' => ['sometimes', 'required', 'string'],
            'company' => ['sometimes', 'required', 'string']
        ]);
    }
}
