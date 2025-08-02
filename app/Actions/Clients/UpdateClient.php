<?php

namespace App\Actions\Clients;

class UpdateClient
{
    public function execute(\App\Models\Client $client, array $data)
    {
        $client->update([
            'name' => $data['name'] ?? $client->name,
            'address' => $data['address'] ?? $client->address,
            'contact_info' => $data['contact_info'] ?? $client->contact_info,
        ]);

        return $client;
    }
}
