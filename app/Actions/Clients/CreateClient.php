<?php

namespace App\Actions\Clients;

class CreateClient
{
    public function execute(array $data, \App\Models\Workspace $workspace)
    {
        return $workspace->clients()->create([
            'name' => $data['name'],
            'address' => $data['address'] ?? null,
            'contact_info' => $data['contact_info'] ?? null,
        ]);
    }
}
