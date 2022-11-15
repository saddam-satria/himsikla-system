<?php


namespace App\Helpers;

use Illuminate\Support\Str;



class StringFactory
{
    public static function lower($payload)
    {
        return Str::lower($payload);
    }
    public static function upper($payload)
    {
        return Str::upper($payload);
    }
    public static function camelcase($payload)
    {
        return Str::camel($payload);
    }
}

class StringHelper
{
    public static function transform(string $type, $payload)
    {
        switch ($type) {
            case 'lowercase':
                $isArray = StringHelper::isArray($payload);
                if ($isArray) {
                    foreach ($payload as $key => $item) {
                        $payload[$key] =  StringFactory::lower($item);
                    }

                    return $payload;
                }

                return StringFactory::lower($payload);

            case "uppercase":
                $isArray = StringHelper::isArray($payload);
                if ($isArray) {
                    foreach ($payload as $key => $item) {
                        $payload[$key] =  StringFactory::upper($item);
                    }

                    return $payload;
                }

                return StringFactory::lower($payload);

            case "camelcase":
                $isArray = StringHelper::isArray($payload);
                if ($isArray) {
                    foreach ($payload as $key => $item) {
                        $payload[$key] =  StringFactory::camelcase($item);
                    }

                    return $payload;
                }

                return StringFactory::lower($payload);
            default:
                return false;
        }
    }
    private static function isArray($payload)
    {
        if (is_array($payload)) return true;

        return false;
    }
}
