<?php namespace NZTim\Token;

use Illuminate\Database\Eloquent\Model;

class TokenDb extends Model implements Token
{
    protected $table = 'tokens';

    // Token implementation

    public function code() : string
    {
        return $this->code;
    }

    public function type() : string
    {
        if (is_null($this->type)) {
            return '';
        }
        return $this->type;
    }

    public function ref() : int
    {
        return $this->ref;
    }
}