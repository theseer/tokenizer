<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, Token>
 */
class TokenCollection implements IteratorAggregate, Countable {

    /** @var Token[] */
    private $tokens = [];

    public function addToken(Token $token): void {
        $this->tokens[] = $token;
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->tokens);
    }

    public function count(): int {
        return \count($this->tokens);
    }

}
