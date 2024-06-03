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
        $contact = Contact::factory()->make()->toArray();
        unset($contact['person_id']);

        $response = $this->post("/api/people/{$person->id}/contacts", $contact);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('contacts', $contact);
    }

    public function testShow()
    {
        $contact = Contact::factory()->create();

        $response = $this->get("/api/contacts/{$contact->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'person_id' => $contact->person_id,
            'type' => $contact->type->value,
            'contact' => $contact->contact,
        ]);
    }

    public function testUpdate()
    {
        $contact = Contact::factory()->create();
        $newContact = Contact::factory()->make()->toArray();
        unset($newContact['person_id']);

        $response = $this->put("/api/contacts/{$contact->id}", $newContact);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('contacts', $newContact);
    }

    public function testDestroy()
    {
        $contact = Contact::factory()->create();

        $response = $this->delete("/api/contacts/{$contact->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
