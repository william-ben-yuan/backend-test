<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->be($this->user);
    }

    public function testIndex()
    {
        $person = Person::factory()->create();
        Contact::factory()->count(3)->for($person)->create();

        $response = $this->get("/api/people/{$person->id}/contacts");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'person_id',
                'type',
                'contact'
            ],
        ]);
    }

    public function testStore()
    {
        $person = Person::factory()->create();
        $contact = Contact::factory()->make();

        $response = $this->post("/api/people/{$person->id}/contacts", $contact->toArray());

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonFragment([
            'person_id' => $person->id,
            'type' => $contact->type,
            'contact' => $contact->contact,
        ]);
    }

    public function testUpdate()
    {
        $contact = Contact::factory()->create();
        $newContact = Contact::factory()->make();
        unset($newContact->person_id);

        $response = $this->put("/api/contacts/{$contact->id}", $newContact->toArray());

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'person_id' => $contact->person_id,
            'type' => $newContact->type,
            'contact' => $newContact->contact,
        ]);
    }

    public function testDestroy()
    {
        $contact = Contact::factory()->create();

        $response = $this->delete("/api/contacts/{$contact->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
