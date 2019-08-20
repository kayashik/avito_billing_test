<?php

namespace App\Http\Controllers\Api;

use App\Models\Generation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenerateController extends BaseController
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function retrieve(
        int $id
    ) : JsonResponse {

        $generation = Generation::find($id);
        if ($generation === null) {
            return $this->respondWithError('Ни одного значения по заданному id не найдено.');
        }
        return $this->respondWithSuccess(
            ['id' => $generation->id, 'result' => $generation->result, 'type' => $generation->type], 'Значение успешно получено.'
        );
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function generate(
        Request $request
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

        $result = null;
        switch ($type) {
            case Generation::TYPE_INT: $result = $this->generateInt($length); // generate rand int can use min and max
                break;
            case Generation::TYPE_GUID: $result = guid(); // generate rand guid
                break;
            case Generation::TYPE_INT_STRING: $result = str_random($length); // generate int and str
                break;
            case Generation::TYPE_SET_VALUE: $result = $this->generateFromSet($length, $values); // generate from set
                break;
            case Generation::TYPE_STRING:
            default:
                $type =  Generation::TYPE_STRING;
                $result = $this->generateStr($length); // generate rand string;
        }

        $generation = Generation::create(['result' => $result, 'type' => $type]);

        return $this->respondWithSuccess(
            ['id' => $generation->id], 'Значение успешно сгенерировано.'
        );
    }

    /**
     * @param int $length
     * @return string
     */
    protected function generateInt(int $length) : string
    {
        $result = '';
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
        return $result;
    }

    /**
     * @param int $length
     * @return string
     */
    protected function generateStr(int $length) : string
    {
        $values = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $valuesLength = mb_strlen($values);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $values[rand(0, $valuesLength - 1)];
        }
        return $result;
    }

    /**
     * @param int $length
     * @param array $values
     * @return string
     */
    private function generateFromSet(int $length, array $values) : string
    {
        $valuesLength = \count($values);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $values[rand(0, $valuesLength - 1)];
        }
        return $result;
    }
}
