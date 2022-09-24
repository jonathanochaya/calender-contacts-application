<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;

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

        $this->user = User::factory()->create();
    }

    /** @test */
    public function an_unauthenticated_user_should_be_redirected_to_login()
    {
        $response = $this->post('/api/contacts', $this->data());

        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function a_list_of_contacts_can_be_retrieved_for_the_authenticated_user()
    {
        $user2 = User::factory()->create();

        $contact = Contact::factory()->create(['user_id' => $this->user->id]);
        $contact2 = Contact::factory()->create(['user_id' => $user2->id]);

        Sanctum::actingAs($this->user);
        $response = $this->get('/api/contacts');

        $response->assertJsonCount(1)
            ->assertJson([
                'data' => [
                    [ 'data' => [
                            'contact_id' => $contact->id
                        ]
                    ]
                ]
            ]);
    }


    /** @test */
    public function an_authenticated_user_can_add_a_contact()
    {
        $this->withoutExceptionHandling();

        Sanctum::actingAs($this->user);

        $response = $this->post('/api/contacts', $this->data());

        $response->assertStatus(Response::HTTP_CREATED);

        $contact = Contact::first();

        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id
            ],
            'links' => [
                'self' => url(Contact::url_path . $contact->id)
            ]
        ]);

        $this->assertEquals($this->name, $contact->name);
        $this->assertEquals($this->email, $contact->email);
        $this->assertEquals($this->birthday, $contact->birthday->format('m/d/Y'));
        $this->assertEquals($this->company, $contact->company);
    }

    /** @test */
    public function fields_are_required()
    {
        Sanctum::actingAs($this->user);

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
        Sanctum::actingAs($this->user);

        $response = $this->post('/api/contacts', array_merge($this->data(), ['email' => 'ochayajonathan']));

        $response->assertSessionHasErrors('email');

        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function birthdays_are_properly_stored()
    {
        Sanctum::actingAs($this->user);

        $respone = $this->post('/api/contacts', $this->data());

        $this->assertCount(1, Contact::all());

        $contact = Contact::first();

        $this->assertInstanceOf(Carbon::class, $contact->birthday);
        $this->assertEquals('05/14/1988', $contact->birthday->format('m/d/Y'));
    }

    /** @test */
    public function a_contact_can_be_retrieved()
    {
        $contact = Contact::factory()->create(['user_id' => $this->user->id]);

        Sanctum::actingAs($this->user);
        $response = $this->get('/api/contacts/' . $contact->id);

        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('m/d/Y'),
                'company' => $contact->company
            ]
        ]);
    }

    /** @test */
    public function only_the_users_contacts_can_be_retrieved()
    {
        $contact = Contact::factory()->create(['user_id' => $this->user->id]);

        $anotherUser = User::factory()->create();

        Sanctum::actingAs($anotherUser);
        $response = $this->get('/api/contacts/' . $contact->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function a_contact_can_be_updated()
    {
        $contact = Contact::factory()->create(['user_id' => $this->user->id]);

        Sanctum::actingAs($this->user);
        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());

        $response->assertStatus(Response::HTTP_OK);

        $contact = $contact->fresh();

        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id
            ],
            'links' => [
                'self' => $contact->path()
            ]
        ]);

        $this->assertEquals($this->name, $contact->name);
        $this->assertEquals($this->email, $contact->email);
        $this->assertEquals($this->birthday, $contact->birthday->format('m/d/Y'));
        $this->assertEquals($this->company, $contact->company);
    }

    /** @test */
    public function only_the_contact_owner_can_make_updates()
    {
        $contact = Contact::factory()->create(['user_id' => $this->user->id]);

        Sanctum::actingAs(User::factory()->create());
        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function a_contact_can_be_deleted()
    {
        $contact = Contact::factory()->create($this->data());

        Sanctum::actingAs($this->user);
        $response = $this->delete('/api/contacts/' . $contact->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function only_the_owner_can_delete_the_contact()
    {
        $contact = Contact::factory()->create($this->data());

        Sanctum::actingAs(User::factory()->create());
        $response = $this->delete('/api/contacts/' . $contact->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function data()
    {
        return [
            'user_id' => $this->user->id,
            'name' => $this->name,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'company' => $this->company
        ];
    }
}
