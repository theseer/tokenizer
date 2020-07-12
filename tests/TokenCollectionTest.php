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
        $this->assertSame($token, $this->collection[0]);
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

    public function testOffsetCanBeUnset(): void {
        $token = $this->createMock(Token::class);
        $this->collection->addToken($token);

        $this->assertCount(1, $this->collection);
        unset($this->collection[0]);
        $this->assertCount(0, $this->collection);
    }

    public function testTokenCanBeSetViaOffsetPosition(): void {
        $token               = $this->createMock(Token::class);
        $this->collection[0] = $token;
        $this->assertCount(1, $this->collection);
        $this->assertSame($token, $this->collection[0]);
    }

    public function testTryingToUseNonIntegerOffsetThrowsException(): void {
        $this->expectException(TokenCollectionException::class);
        $this->collection['foo'] = $this->createMock(Token::class);
    }

    public function testTryingToSetNonTokenAtOffsetThrowsException(): void {
        $this->expectException(TokenCollectionException::class);
        $this->collection[0] = 'abc';
    }

    public function testTryingToGetTokenAtNonExistingOffsetThrowsException(): void {
        $this->expectException(TokenCollectionException::class);
        $x = $this->collection[3];
    }
}
