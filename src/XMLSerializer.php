<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use DOMDocument;

class XMLSerializer {

    /** @var NamespaceUri */
    private $xmlns;

    /**
     * XMLSerializer constructor.
     *
     * @param NamespaceUri $xmlns
     */
    public function __construct(?NamespaceUri $xmlns = null) {
        if ($xmlns === null) {
            $xmlns = new NamespaceUri('https://github.com/theseer/tokenizer');
        }
        $this->xmlns = $xmlns;
    }

    public function toDom(TokenCollection $tokens): DOMDocument {
        $dom                     = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($this->toXML($tokens));

        return $dom;
    }

    public function toXML(TokenCollection $tokens): string {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->setIndent(true);
        $writer->startDocument();
        $writer->startElement('source');
        $writer->writeAttribute('xmlns', $this->xmlns->asString());

        if (\count($tokens) > 0) {
            $writer->startElement('line');
            $writer->writeAttribute('no', '1');

            $tokens->rewind();
            $previousToken = $tokens->current();

            foreach ($tokens as $token) {
                if ($previousToken->getLine() < $token->getLine()) {
                    $writer->endElement();
        
                    $writer->startElement('line');
                    $writer->writeAttribute('no', (string)$token->getLine());
                    $previousToken = $token;
                }
        
                if ($token->getValue() !== '') {
                    $writer->startElement('token');
                    $writer->writeAttribute('name', $token->getName());
                    $writer->writeRaw(\htmlspecialchars($token->getValue(), \ENT_NOQUOTES | \ENT_DISALLOWED | \ENT_XML1));
                    $writer->endElement();
                }
            }
        }

        $writer->endElement();
        $writer->endElement();
        $writer->endDocument();

        return $writer->outputMemory();
    }
}
