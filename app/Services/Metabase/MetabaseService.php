<?php

declare(strict_types=1);

namespace App\Services\Metabase;

use App\Services\Metabase\Exceptions\ParamsRequiredException;
use App\Services\Metabase\Exceptions\QuestionIdRequiredException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use STS\JWT\Facades\JWT;

class MetabaseService
{
    private string $url;
    private string $secret;
    private Carbon $expiresAt;
    private array $params = [];
    private ?int $questionId = null;


    public function __construct()
    {
        $this->url = config('metabase.url');
        $this->secret = config('metabase.secret');
        $this->expiresAt = now()->addMinutes(10);
    }

    /**
     * @throws QuestionIdRequiredException
     * @throws ParamsRequiredException
     */
    public function getIFrameUrl(): string
    {
        $token = $this->getToken();

        return "$this->url/embed/question/$token/#theme=night&titled=false";
    }

    /**
     * @throws QuestionIdRequiredException
     * @throws ParamsRequiredException
     */
    private function getToken(): string
    {
        if (!isset($this->questionId)) {
            throw new QuestionIdRequiredException();
        }

        if (empty($this->params)) {
            throw new ParamsRequiredException();
        }

        return JWT::signWith($this->secret)->withClaims([
            'resource' => ['question' => $this->questionId],
            'params' => $this->params,
        ])->expiresAt($this->expiresAt)->getToken()->toString();
    }

    public function setExpiresAt(Carbon $carbon): self
    {
        $this->expiresAt = $carbon;

        return $this;
    }

    public function setParams(array $params): self
    {
        if (array_key_exists('user_id', $params) && $params['user_id'] === '$authUserId') {
            $params['user_id'] = Auth::id();
        }

        $this->params = $params;

        return $this;
    }

    public function setQuestionId(int $questionId): self
    {
        $this->questionId = $questionId;

        return $this;
    }
}
