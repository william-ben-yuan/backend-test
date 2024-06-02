<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonRepository
{
    public function getAllPersons()
    {
        return Person::all();
    }

    public function create(Request $request): Person
    {
        return Person::create($request->all());
    }

    public function update(Request $request, Person $person): Person
    {
        $person->update($request->all());
        return $person;
    }

    public function delete(Person $person): void
    {
        $person->delete();
    }
}
