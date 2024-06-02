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

    public function create(array $request): Person
    {
        return Person::create($request);
    }

    public function update(array $request, Person $person): Person
    {
        $person->update($request);
        return $person;
    }

    public function delete(Person $person): void
    {
        $person->delete();
    }
}
