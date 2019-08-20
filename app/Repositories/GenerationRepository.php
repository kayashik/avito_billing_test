<?php

namespace App\Repositories;

use App\Models\Generation;

class GenerationRepository
{
    public function findById(int $id) : ?Generation
    {
        return Generation::find($id);
    }

    public function createRaw(array $data) : Generation
    {
        return Generation::create($data);
    }
}
