<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;
use Carbon\Carbon;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->name = 'Test Name';
        $this->email = 'test@email.com';
        $this->birthday = '05/14/1988';
        $this->company = 'ACME Inc.';
    }

    /** @test */
    public function a_contact_can_be_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        $this->assertEquals($this->name, $contact->name);
        $this->assertEquals($this->email, $contact->email);
        $this->assertEquals($this->birthday, $contact->birthday->format('m/d/Y'));
        $this->assertEquals($this->company, $contact->company);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['name', 'email', 'birthday', 'company'])
            ->each(function($field) {
                $response = $this->post('/api/contacts', array_merge($this->data(), [$field => '']));

                $response->assertSessionHasErrors($field);

                $this->assertCount(0, Contact::all());
            });
    }

    /** @test */
    public function email_must_be_valid_email()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['email' => 'ochayajonathan']));

        $response->assertSessionHasErrors('email');

        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function birthdays_are_properly_stored()
    {
        $respone = $this->post('/api/contacts', $this->data());

        $this->assertCount(1, Contact::all());

        $contact = Contact::first();

        $this->assertInstanceOf(Carbon::class, $contact->birthday);
        $this->assertEquals('05-14-1988', $contact->birthday->format('m-d-Y'));
    }

    /** @test */
    public function a_contact_can_be_retrieved()
    {
        $contact = Contact::factory()->create();

        $response = $this->get('/api/contacts/' . $contact->id);

        $response->assertJson([
            'name' => $contact->name,
            'email' => $contact->email,
            'birthday' => $contact->birthday->format('m-d-Y'),
            'company' => $contact->company
        ]);
    }

    /** @test */
    public function a_contact_can_be_updated()
    {
        $contact = Contact::factory()->create();

        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());

        $response->assertStatus(200);

        $contact = $contact->fresh();

        $this->assertEquals($this->name, $contact->name);
        $this->assertEquals($this->email, $contact->email);
        $this->assertEquals($this->birthday, $contact->birthday->format('m/d/Y'));
        $this->assertEquals($this->company, $contact->company);
    }

    /** @test */
    public function a_contact_can_be_deleted()
    {
        $contact = Contact::factory()->create();

        $response = $this->delete('/api/contacts/' . $contact->id);

        $response->assertStatus(200);

        $this->assertCount(0, Contact::all());
    }

    public function data()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'company' => $this->company
        ];
    }
}
