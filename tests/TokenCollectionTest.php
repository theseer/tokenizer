<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use PHPUnit\Framework\TestCase;

/**
 * @covers \TheSeer\Tokenizer\TokenCollection
 */
class TokenCollectionTest extends TestCase {

    /** @var TokenCollection */
    private $collection;

    protected function setUp(): void {
        $this->collection = new TokenCollection();
    }

    public function testCollectionIsInitiallyEmpty(): void {
        $this->assertCount(0, $this->collection);
    }

    public function testTokenCanBeAddedToCollection(): void {
        $token = $this->createMock(Token::class);
        $this->collection->addToken($token);

        $this->assertCount(1, $this->collection);
        $this->assertSame($token, $this->collection->getIterator()->current());
    }

    public function testCanIterateOverTokens(): void {
        $token = $this->createMock(Token::class);
        $this->collection->addToken($token);
        $this->collection->addToken($token);

        foreach ($this->collection as $position => $current) {
            $this->assertIsInt($position);
            $this->assertSame($token, $current);
        }
    }
}
