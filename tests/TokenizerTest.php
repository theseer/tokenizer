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

    public function testParsingEmptyStringReturnsEmptyCollection(): void {
        $this->assertCount(
            0,
            (new Tokenizer())->parse('')
        );
    }

    /**
     * @ticket https://github.com/theseer/tokenizer/issues/13
     */
    public function testFileWithSingleEmptyLineGetsParsed(): void {
        $this->assertParsedTokensMatchFixture('source_with_single_empty_line.php');
    }

    private function assertParsedTokensMatchFixture(string $fixture): void {
        $expected = \unserialize(
            \file_get_contents(__DIR__ . '/_files/' . $fixture . '.tokens'),
            [TokenCollection::class, Token::class]
        );

        $actual = (new Tokenizer)->parse(\file_get_contents(__DIR__ . '/_files/' . $fixture));

        $this->assertEquals($expected, $actual);
    }
}
