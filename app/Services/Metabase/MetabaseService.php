<?php

declare(strict_types=1);

namespace App\Services\Metabase;

use App\Services\Enums\MetabaseSharedObjectType;
use App\Services\Metabase\Exceptions\ObjectRequiredException;
use App\Services\Metabase\Exceptions\ParamsRequiredException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use STS\JWT\Facades\JWT;

class MetabaseService
{
    private string $url;
    private string $secret;
    private Carbon $expiresAt;
    private array $params = [];
    private ?int $objectId = null;
    private ?MetabaseSharedObjectType $type;


    public function __construct()
    {
        $this->url = config('metabase.url');
        $this->secret = config('metabase.secret');
        $this->expiresAt = now()->addMinutes(10);
    }

    /**
     * @throws ObjectRequiredException
     * @throws ParamsRequiredException
     */
    public function getIFrameUrl(): string
    {
        $token = $this->getToken();
        $type = $this->type->value;

        return "$this->url/embed/$type/$token/?params=0#theme=night&titled=false";
    }

    /**
     * @throws ObjectRequiredException
     * @throws ParamsRequiredException
     */
    private function getToken(): string
    {
        if (!isset($this->objectId) || !isset($this->type)) {
            throw new ObjectRequiredException();
        }

        if (empty($this->params)) {
            throw new ParamsRequiredException();
        }

        return JWT::signWith($this->secret)->withClaims([
            'resource' => [
                $this->type->value => $this->objectId,
            ],
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

    public function setObjectType(MetabaseSharedObjectType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setObjectId(int $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }
}
