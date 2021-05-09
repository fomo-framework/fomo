<?php

namespace Core;

use Workerman\Protocols\Http\Response;

class JsonResponse
{
    public function collection($resource): Response
    {
        $array = array();

        foreach ($resource as $value){
            array_push($array , $this->toArray($value));
        }

        if (method_exists($resource , 'perPage'))
            return json([
                'data' => $array ,
                'meta' => [
                    'count' => $resource->lastItem() ,
                    'lastPage' => ceil($resource->lastItem() / $resource->perPage()) ,
                    'prePage' => $resource->perPage() ,
                ]
            ] , 200);

        return json([
            'data' => $array ,
        ] , 200);
    }

    public function single($resource): Response
    {
        $resource = $this->toArray($resource);
        return json([
            'data' => $resource
        ] , 200);

    }

    protected function toArray($request)
    {
        return $request;
    }
}