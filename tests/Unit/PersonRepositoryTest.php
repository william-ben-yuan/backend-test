<?php

namespace Tests\Unit;

use App\Models\Person;
use App\Repositories\PersonRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new PersonRepository();
    }

    public function testGetAllPersons(): void
    {
        Person::factory()->count(3)->create();

        $fetchedPersons = $this->repository->getAllPersons();

        $this->assertCount(3, $fetchedPersons);
    }

    public function testCreate(): void
    {
        $personData = Person::factory()->make()->toArray();
        $person = $this->repository->create($personData);

        $this->assertDatabaseHas('people', ['id' => $person->id]);
    }

    public function testUpdate(): void
    {
        $person = Person::factory()->create();
        $newPersonData = Person::factory()->make()->toArray();

        $updatedPerson = $this->repository->update($newPersonData, $person);

        $this->assertDatabaseHas('people', ['id' => $updatedPerson->id]);
    }

    public function testDelete(): void
    {
        $person = Person::factory()->create();

        $this->repository->delete($person);

        $this->assertDatabaseMissing('people', ['id' => $person->id]);
    }
}
