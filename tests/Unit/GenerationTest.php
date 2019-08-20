<?php

namespace Tests\Unit;

use App\Models\Generation;
use App\Services\GenerationService;
use Tests\TestCase;

class GenerationTest extends TestCase
{
    public function testGenerateInt()
    {
        $generationService = app(GenerationService::class);
        $type = Generation::TYPE_INT;
        $length = 16;
        $result = $generationService->generate($type, $length);
        preg_match_all("/[^0-9]/", $result, $matches);
        $this->assertTrue(\count($matches[0]) === 0 && mb_strlen($result) === $length);

    }

    public function testGenerateStr()
    {
        $generationService = app(GenerationService::class);
        $type = Generation::TYPE_STRING;
        $length = 16;
        $result = $generationService->generate($type, $length);
        preg_match_all("/[^a-zA-Z]/", $result, $matches);
        $this->assertTrue(\count($matches[0]) === 0 && mb_strlen($result) === $length);

    }

    public function testGenerateIntStr()
    {
        $generationService = app(GenerationService::class);
        $type = Generation::TYPE_STRING;
        $length = 16;
        $result = $generationService->generate($type, $length);
        preg_match_all("/[^0-9a-zA-Z]/", $result, $matches);
        $this->assertTrue(\count($matches[0]) === 0 && mb_strlen($result) === $length);

    }

    public function testGenerateIntSet()
    {
        $generationService = app(GenerationService::class);
        $type = Generation::TYPE_SET_VALUE;
        $length = 16;
        $values = ['a', 'b', 'c', '1', '4'];
        $result = $generationService->generate($type, $length, $values);
        $pattern = implode("", $values) ;
        preg_match_all("/[^" . $pattern . "]/", $result, $matches);
        $this->assertTrue(\count($matches[0]) === 0 && mb_strlen($result) === $length);

    }

    public function testAccessGenerationFromDb()
    {
        // load post manually first
        $dbGeneration = \DB::select('select * from generations where id = 1');

        $dbGenerationResult = isset($dbGeneration[0]) ? ucfirst($dbGeneration[0]->result) : null;

        // load post using Eloquent
        $modelGeneration = Generation::find(1);
        $modelGenerationResult = $modelGeneration !== null ? $modelGeneration->result : null;

        $this->assertEquals($dbGenerationResult, $modelGenerationResult);

    }

}
