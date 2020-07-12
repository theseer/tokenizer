<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase {

    /** @var Token */
    private $token;

    protected function setUp(): void {
        $this->token = new Token(1, 'test-dummy', 'blank');
    }

    public function testTokenCanBeCreated(): void {
        $this->assertInstanceOf(Token::class, $this->token);
    }

    public function testTokenLineCanBeRetrieved(): void {
        $this->assertEquals(1, $this->token->getLine());
    }

    public function testTokenNameCanBeRetrieved(): void {
        $this->assertEquals('test-dummy', $this->token->getName());
    }

    public function testTokenValueCanBeRetrieved(): void {
        $this->assertEquals('blank', $this->token->getValue());
    }
}
