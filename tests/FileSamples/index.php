<?php

class Sample
{
    const message = "this is just a dummy class";

    public function ok()
    {
        print $this::message;
    }
}