<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Casesnotes extends ResourceCollection
{

    protected $parentId;

    public function __construct($resource, $parentId)
    {
        $this->parentId = $parentId;
        parent::__construct($resource);
    }


    public function toArray($request)
    {

        return [
            'data' => $this->collection,
            'parentId' => $this->parentId,
            'parentCategory' => 'casefiles'
        ];

    }

}
