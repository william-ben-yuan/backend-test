<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ContactRepository
{
    public function getAllContacts(Person $person): Collection
    {
        return $person->contacts;
    }

    public function create(Request $request, Person $person): Contact
    {
        $contact = new Contact($request->all());
        $person->contacts()->save($contact);
        return $contact;
    }

    public function find(int $id): ?Contact
    {
        return Contact::find($id);
    }

    public function update(Request $request, Contact $contact): Contact
    {
        $contact->update($request->all());
        return $contact;
    }

    public function delete(Contact $contact): void
    {
        $contact->delete();
    }
}
