<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\Person;
use App\Repositories\ContactRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ContactRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new ContactRepository();
    }

    public function testGetAllContacts(): void
    {
        $person = Person::factory()->create();
        Contact::factory()->count(3)->for($person)->create();
        $fetchedContacts = $this->repository->getAllContacts($person);

        $this->assertCount(3, $fetchedContacts);
    }

    public function testStore(): void
    {
        $person = Person::factory()->create();
        $contact = Contact::factory()->make();

        $createdContact = $this->repository->create($contact->toArray(), $person);

        $this->assertDatabaseHas('contacts', [
            'id' => $createdContact->id,
            'person_id' => $person->id,
            'type' => $contact->type,
            'contact' => $contact->contact,
        ]);
    }

    public function testUpdate(): void
    {
        $contact = Contact::factory()->create();
        $newContact = Contact::factory()->make();
        unset($newContact->person_id);

        $updatedContact = $this->repository->update($newContact->toArray(), $contact);

        $this->assertDatabaseHas('contacts', [
            'id' => $updatedContact->id,
            'person_id' => $contact->person_id,
            'type' => $newContact->type,
            'contact' => $newContact->contact,
        ]);
    }

    public function testDelete(): void
    {
        $contact = Contact::factory()->create();

        $this->repository->delete($contact);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
