<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Services\Tenancy\TenantFactory;
use Tests\TestCase;

class MemberControllerListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $tenantFactory = $this->app->get(TenantFactory::class);
        $this->tenant1 = $tenantFactory->create('tenant1@example.com');
        $tenant1Members = ['Alice', 'Bob', 'David'];
        foreach ($tenant1Members as $tenant1Member) {
            $member = new Member();
            $member->name = $tenant1Member;
            $member->user_id = $this->tenant1->id;
            $member->save();
        }

        $this->tenant2 = $tenantFactory->create('tenant2@example.com');
        $tenant2Members = ['Charles'];
        foreach ($tenant2Members as $tenant2Member) {
            $member = new Member();
            $member->name = $tenant2Member;
            $member->user_id = $this->tenant2->id;
            $member->save();
        }
    }

    public function test_tenant1(): void
    {
        $response = $this
            ->actingAs($this->tenant1)
            ->getJson('/api/members')
            ->assertOk()
        ;

        $data = json_decode($response->getContent(), true);
        $this->assertCount(3, $data);
        $foundMembers = array_map(function (array $row) {
            return $row['name'];
        }, $data);
        $this->assertFalse(in_array('Charles', $foundMembers, true), 'tenant2のメンバーを含まない');
    }

    public function test_tenant2(): void
    {
        $response = $this
            ->actingAs($this->tenant2)
            ->getJson('/api/members')
            ->assertOk()
        ;

        $data = $response->decodeResponseJson();
        $this->assertCount(1, $data);
        $this->assertEquals('Charles', $data[0]['name']);
    }
}
