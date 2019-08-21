<?php

namespace App\Services;

use App\Models\Generation;

class GenerationService
{
    /**
     * @param string $type
     * @param int $length
     * @param array|null $values
     * @return string
     */
    public function generate(
        string &$type = null,
        int $length = null,
        array $values = null
    ) : string {

        $length = $length !== null ? $length : 16;
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

        return $result;

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
