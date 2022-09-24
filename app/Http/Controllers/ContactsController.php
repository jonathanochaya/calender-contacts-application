<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function index()
    {
        return request()->user()->contacts;
    }

    public function store()
    {
        Contact::create($this->validateData());
    }

    public function show(Contact $contact)
    {
        if(request()->user()->id !== $contact->user_id) {
            return abort(403);
        }

        return new ContactResource($contact);
    }

    public function update(Contact $contact)
    {
        $contact->update($this->validateData());
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
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
