<?php

namespace App\Http\Controllers\Api;

use App\Models\Generation;
use App\Repositories\GenerationRepository;
use App\Services\GenerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenerateController extends BaseController
{

    /**
     * @param int $id
     * @param GenerationRepository $generationRepo
     * @return JsonResponse
     */
    public function retrieve(
        int $id,
        GenerationRepository $generationRepo
    ) : JsonResponse {

        $generation = $generationRepo->findById($id);
        if ($generation === null) {
            return $this->respondWithError('Ни одного значения по заданному id не найдено.');
        }
        return $this->respondWithSuccess(
            ['id' => $generation->id, 'result' => $generation->result, 'type' => $generation->type], 'Значение успешно получено.'
        );
    }


    /**
     * @param Request $request
     * @param GenerationService $generationService
     * @param GenerationRepository $generationRepo
     * @return JsonResponse
     */
    public function generate(
        Request $request,
        GenerationService $generationService,
        GenerationRepository $generationRepo
    ) : JsonResponse {
        $type = $request->input('type');

        $values = null;
        $length = $request->has('length') ? $request->input('length') : 16;

        if ($type === Generation::TYPE_SET_VALUE) {
            $values = $request->input('values');
            if ($values === null || is_array($values) === false || \count($values) === 0) {
                return $this->respondWithError('Необходимо задать значения для генерации. Значения должны быть в массиве.');
            }
        }
        $result = $generationService->generate($type, $length, $values);

        $generation = $generationRepo->createRaw(['result' => $result, 'type' => $type]);

        return $this->respondWithSuccess(
            ['id' => $generation->id], 'Значение успешно сгенерировано.'
        );
    }

}
