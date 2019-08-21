<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\GenerationCreateRequest;
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
        GenerationCreateRequest $request,
        GenerationService $generationService,
        GenerationRepository $generationRepo
    ) : JsonResponse {

        $type = $request->input('type');

        $result = $generationService->generate($type, $request->input('length'), $request->input('values'));
        $generation = $generationRepo->createRaw(['result' => $result, 'type' => $type]);

        return $this->respondWithSuccess(
            ['id' => $generation->id], 'Значение успешно сгенерировано.'
        );
    }

}
