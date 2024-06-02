<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Repositories\PersonRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function index(): JsonResponse
    {
        $persons = $this->personRepository->getAllPersons();
        return response()->json($persons);
    }

    public function store(Request $request): JsonResponse
    {
        $person = $this->personRepository->create($request);
        return response()->json($person, Response::HTTP_CREATED);
    }

    public function show(Person $person): JsonResponse
    {
        return response()->json($person->load('contacts'));
    }

    public function update(Request $request, Person $person): JsonResponse
    {
        $person = $this->personRepository->update($request, $person);
        return response()->json($person);
    }

    public function destroy(Person $person): JsonResponse
    {
        $this->personRepository->delete($person);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
