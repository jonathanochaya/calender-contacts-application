<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Validation\Rule;

class ContactsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Contact::class);

        return request()->user()->contacts;
    }

    public function store()
    {
        $this->authorize('create', Contact::class);

        request()->user()->contacts()->create($this->validateData());
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return new ContactResource($contact);
    }

    public function update(Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update($this->validateData());
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

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
