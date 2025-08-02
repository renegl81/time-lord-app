<?php

namespace App\Actions\Tags;

class CreateTag
{
    public function execute(array $data, \App\Models\Workspace $workspace)
    {
        return $workspace->tags()->create([
            'name' => $data['name'],
            'color' => $data['color'] ?? '#'.substr(md5(rand()), 0, 6),
        ]);
    }
}
