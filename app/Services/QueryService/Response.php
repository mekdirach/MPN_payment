<?php

namespace App\Services\QueryService;

use Exception;
use Illuminate\Support\Collection;

class Response
{
    protected $mResponse;

    public function __construct($pResponseStream)
    {
        if ($pResponseStream == '') {
            throw new Exception('Got null response from QS');
        }
        $this->mResponse = json_decode($pResponseStream);
    }

    public function isSuccess($pIsSelectQuery = true)
    {
        return $pIsSelectQuery
            ? in_array($this->getRC(), ['0000', '0014'])
            : in_array($this->getRC(), ['0000']);
    }

    public function getRC()
    {
        return $this->mResponse->RC;
    }

    public function getError()
    {
        return $this->mResponse->e ?? json_encode($this->mResponse);
    }

    public function getData()
    {
        if ($this->getRC() == '0014') {
            return collect();
        }

        return collect(json_decode($this->mResponse->o));
    }

    public function getDataJson()
    {
        if ($this->getRC() == '0000') {
            return collect();
        }

        return collect(json_decode($this->mResponse->o));
    }
}
