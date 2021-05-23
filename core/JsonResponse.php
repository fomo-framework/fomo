<?php

namespace Core;

use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use stdClass;

class JsonResponse
{
    protected Collection|LengthAwarePaginator|Builder|stdClass $collection;

    protected array $response = [];

    protected bool $isRelation;

    public function __construct(Collection|LengthAwarePaginator|Builder|stdClass $collection , bool $isRelation = false)
    {
        $this->collection = $collection;
        $this->isRelation = $isRelation;
        if ($collection instanceof LengthAwarePaginator || $collection instanceof Collection)
            $this->process();
    }

    public function collection(): Response|array
    {
        if ($this->isRelation == true)
        {
            return $this->response;
        }

        if (method_exists($this->collection , 'perPage'))
            return json([
                'data' => $this->response ,
                'meta' => [
                    'count' => $this->collection->total() ,
                    'lastPage' => ceil($this->collection->total() / $this->collection->perPage()) ,
                    'prePage' => $this->collection->perPage() ,
                ]
            ]);

        return json([
            'data' => $this->response ,
        ]);
    }

    public function single(): Response
    {
        return json([
            'data' => $this->toArray($this->collection)
        ]);
    }

    protected function process(): void
    {
        $this->collection->map(function ($collection){
            array_push($this->response , $this->toArray($collection));
        });
    }

    protected function toArray($request)
    {
        return $request;
    }
}
