<?php

namespace App\PSRManipulator\Traits;

trait DelegatesAPICalls
{
    public function __call($method, $args) {
        // Find handler resource instance
        $resource = $this->getTargetResource($method);
        // setter, getter, adder, remover or other ?
        $requestType = $this->getRequestType($method, $args);
        // dispatch method call to resource handler
        return $resource ? $resource->$requestType($method, $args) : $this->$method($args);
    }

    private function getRequestType($method, $args)
    {
        // exact matches are getters/setters
        if(collect($this->resources)->contains($method)) {
            return $args ? 'set' : 'get';
        }

        // addResource ?
        collect($this->resources)->each(function($resource) {
            if(preg_match("/^add$resource\$/i", $resource)) {
                return 'add';
            }
        });

        // removeResource ?
        collect($this->resources)->each(function($resource) {
            if(preg_match("/^remove$resource\$/i", $resource)) {
                return 'remove';
            }
        });        

        return 'other';
    }

    private function getTargetResource($method)
    {
        return collect($this->resources)->filter(function($resource) use($method) {
            return preg_match("/^$resource\$/i", $method)
                || preg_match("/^add$resource\$/i", $method)
                || preg_match("/^remove$resource\$/i", $method);
        })->first();
    }
}