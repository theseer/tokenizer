<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use PHPUnit\Framework\TestCase;

/**
 * @covers \TheSeer\Tokenizer\Tokenizer
 */
class TokenizerTest extends TestCase {
    public function testValidSourceGetsParsed(): void {
        $this->assertParsedTokensMatchFixture('test.php');
    }

    private function assertParsedTokensMatchFixture(string $fixture): void
    {
        $expected = \unserialize(
            \file_get_contents(__DIR__ . '/_files/' . $fixture . '.tokens'),
            [TokenCollection::class, Token::class]
        );

        $actual = (new Tokenizer)->parse(\file_get_contents(__DIR__ . '/_files/' . $fixture));

        $this->assertEquals($expected, $actual);
    }
}
