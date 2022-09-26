<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResourceCollection;
use App\Models\Contact;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $term = request()->validate([
            'searchTerm' => ['string', 'required']
        ]);

        return new ContactResourceCollection(Contact::search($term['searchTerm'])
                ->where('user_id', request()->user()->id)->get());
    }
}
