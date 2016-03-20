<?php namespace NZTim\Token;

use Carbon\Carbon;

class TokenRepo
{
    protected $model;

    public function __construct(TokenDb $model)
    {
        $this->model = $model;
    }

    public function new(int $ref, string $type, int $expires = null) : string
    {
        /** @var TokenDb $token */
        $token = $this->model->newInstance();
        $token->type = $type;
        $token->ref = $ref;
        $token->code = $this->uniqueCode();
        $token->expires = $expires;
        $token->save();
        return $token->code;
    }

    protected function uniqueCode() : string
    {
        $code = str_random(40);
        while (!is_null($this->model->whereCode($code)->first())) {
            $code = str_random(40);
        }
        return $code;
    }

    /**
     * @param string $code
     * @param string $type
     * @return int|null
     */
    public function find(string $code, string $type)
    {
        $this->expire();
        $token = $this->model->whereCode($code)->whereType($type)->first();
        if (is_null($token)) {
            return null;
        }
        return $token->ref;
    }

    protected function expire()
    {
        $tokens = $this->model->all();
        foreach($tokens as $token) {
            if (is_null($token->expires)) {
                continue;
            }
            if(Carbon::now()->subMinutes($token->expires)->gt($token->created_at)) {
                $token->delete();
            }
        }
    }

    public function remove(string $code, string $type)
    {
        /** @var TokenDb $token */
        $token = $this->model->whereCode($code)->whereType($type)->first();
        if ($token) {
            $token->delete();
        }
    }
}