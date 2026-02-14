<?php

namespace App\Exceptions;

use App\Models\Post;
use RuntimeException;

class DuplicatePostException extends RuntimeException
{
    public function __construct(
        protected string $reason,
        protected ?Post $matchedPost = null,
        protected ?float $score = null
    ) {
        parent::__construct($reason);
    }

    public function reason(): string
    {
        return $this->reason;
    }

    public function matchedPost(): ?Post
    {
        return $this->matchedPost;
    }

    public function score(): ?float
    {
        return $this->score;
    }
}
