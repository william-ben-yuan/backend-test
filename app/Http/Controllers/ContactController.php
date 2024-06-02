<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Person;
use App\Repositories\ContactRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index(Person $person): JsonResponse
    {
        $contacts = $this->contactRepository->getAllContacts($person);
        return response()->json($contacts);
    }

    public function store(Request $request, Person $person): JsonResponse
    {
        $contact = $this->contactRepository->create($request, $person);
        return response()->json($contact, Response::HTTP_CREATED);
    }

    public function update(Request $request, Contact $contact)
    {
        $contact = $this->contactRepository->update($request, $contact);
        return $contact;
    }

    public function destroy(Contact $contact)
    {
        $this->contactRepository->delete($contact);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
