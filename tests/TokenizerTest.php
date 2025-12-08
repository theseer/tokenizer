<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use PHPUnit\Framework\TestCase;
use function file_get_contents;

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

    public function testParsingCodeWithAmpersandReturnsCorrectToken(): void {
        $result = (new Tokenizer())->parse('<?php function x(&$a) {}');
        $this->assertEquals(
            'T_AMPERSAND_FOLLOWED_BY_VAR_OR_VARARG',
            $result[5]->getName()
        );
    }

    /**
     * @ticket https://github.com/theseer/tokenizer/issues/13
     */
    public function testFileWithSingleEmptyLineGetsParsed(): void {
        $this->assertParsedTokensMatchFixture('source_with_single_empty_line.php');
    }

    private function assertParsedTokensMatchFixture(string $fixture): void {
        $expected = unserialize(
            file_get_contents(__DIR__ . '/_files/' . $fixture . '.tokens'),
            [TokenCollection::class, Token::class]
        );

        $actual = (new Tokenizer)->parse(file_get_contents(__DIR__ . '/_files/' . $fixture));
        $this->assertEquals($expected, $actual);
    }
}
