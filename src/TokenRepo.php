<?php namespace NZTim\Token;

use Carbon\Carbon;

class TokenRepo
{
    protected $model;
    protected $timeout;

    public function __construct(TokenDb $model, int $timeout = 1440) // 60mins * 24h
    {
        $this->model = $model;
        $this->timeout = $timeout;
    }

    public function new(int $ref, string $type = null) : Token
    {
        $token = $this->model->newInstance();
        $token->type = $type;
        $token->ref = $ref;
        $token->code = $this->uniqueCode();
        $this->persist($token);
        return $token;
    }

    protected function uniqueCode() : string
    {
        $code = str_random(40);
        while (!is_null($this->model->whereCode($code)->first())) {
            $code = str_random(40);
        }
        return $code;
    }

    protected function persist(TokenDb $token)
    {
        $token->save();
    }

    /**
     * @param string $code
     * @param string|null $type
     * @return Token|null
     */
    public function find(string $code, string $type = null)
    {
        $this->expire();
        if (is_null($type)) {
            return $this->model->whereCode($code)->first();
        }
        return $this->model->whereCode($code)->whereType($type)->first();
    }

    protected function expire()
    {
        $this->model->where('created_at', '<', Carbon::now()->subMinutes($this->timeout))->delete();
    }

    public function remove(Token $token)
    {
        /** @var TokenDb $token */
        $token->delete();
    }
}