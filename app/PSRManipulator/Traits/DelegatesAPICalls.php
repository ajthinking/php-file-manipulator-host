<?php

namespace App\PSRManipulator\Traits;
use Illuminate\Support\Str;
use BadMethodCallException;

trait DelegatesAPICalls
{
    public function __call($method, $args) {
        // Find handler resource instance
        $resource = $this->getTargetResource($method);
        // setter, getter, adder, remover or other ?
        $requestType = $this->getRequestType($method, $args);
        // dispatch method call to resource handler or fallback to $this
        return $resource ? $resource->$requestType(...$args) : $this->callOnSelf($method, ...$args);
    }

    private function getRequestType($method, $args)
    {
        foreach($this->resources as $resource) {
            // exact matches are getters/setters
            if(preg_match("/^$resource\$/i", $method)) {
                return $args ? 'set' : 'get';
            }
            // adders
            if(preg_match("/^add$resource\$/i", $method)) {
                return 'add';
            }
            // removers
            if(preg_match("/^remove$resource\$/i", $method)) {
                return 'remove';
            }            
        }

        return 'other';
    }

    private function getTargetResource($method)
    {
        $resource = collect($this->resources)->filter(function($resource) use($method) {
            return preg_match("/^$resource\$/i", $method)
                || preg_match("/^add$resource\$/i", $method)
                || preg_match("/^remove$resource\$/i", $method);
        })->first();

        if(!$resource) return;

        $resourceClass = "App\PSRManipulator\Resources\\" . Str::studly($resource) . "Resource";
        return new $resourceClass($this);
    }

    private function callOnSelf($method, $args = [])
    {
        $methods = get_class_methods($this);
        if(collect($methods)->contains($method)) return $this->$method($args);

        throw new BadMethodCallException("$method: No such method!");
    }
}