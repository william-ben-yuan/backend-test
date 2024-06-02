<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->be($this->user);
    }

    public function testIndex(): void
    {
        Person::factory()->count(3)->create();


        $response = $this->get('/api/people');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name'
            ],
        ]);
    }

    public function testShow(): void
    {
        $person = Person::factory()->create();
        Contact::factory()->count(3)->for($person)->create();

        $response = $this->get("/api/people/{$person->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'id' => $person->id,
            'name' => $person->name,
            'contacts' => $person->contacts->toArray(),
        ]);
    }

    public function testStore(): void
    {
        $personData = Person::factory()->make()->toArray();

        $response = $this->post('/api/people', $personData);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('people', $personData);
    }

    public function testUpdate(): void
    {
        $person = Person::factory()->create();
        $newPersonData = Person::factory()->make()->toArray();

        $response = $this->put("/api/people/{$person->id}", $newPersonData);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('people', $newPersonData);
    }

    public function testDestroy(): void
    {
        $person = Person::factory()->create();

        $response = $this->delete("/api/people/{$person->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('people', ['id' => $person->id]);
    }
}
