<?php namespace NZTim\Token;

interface Token
{
    public function code() : string;
    public function ref() : int;
    public function type(): string;
}