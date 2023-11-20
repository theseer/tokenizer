<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use DOMXPath;
use PHPUnit\Framework\TestCase;

/**
 * @ticket https://github.com/theseer/tokenizer/issues/18
 */
class Issue18Test extends TestCase {

    public function testIssueNoLongerOccurs() {
        $result = (new Tokenizer)->parse(\file_get_contents(__DIR__ . '/_files/Issue-18.php'));

        $dom = (new XMLSerializer())->toDom($result);

        $node = (new DOMXPath($dom))->query('//*[@no="18"]/*')->item(1);

        $this->assertEquals('{binary data}', $node->textContent);
    }

}
