<?php

declare(strict_types=1);

namespace JustCoded\PhpCsFixer\Fixers;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

final class DeclareStrictTypesFixer extends AbstractFixer implements WhitespacesAwareFixerInterface
{
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Force strict types declaration in all files.',
            [
                new CodeSample(
                    "<?php\n",
                ),
            ],
            null,
            'Forcing strict types will stop non strict code from working.',
        );
    }

    public function getPriority(): int
    {
        return 2;
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return isset($tokens[0]) && $tokens[0]->isGivenKind(T_OPEN_TAG);
    }

    public function isRisky(): bool
    {
        return true;
    }

    protected function applyFix(SplFileInfo $file, Tokens $tokens): void
    {
        // check if the declaration is already done
        $searchIndex = $tokens->getNextMeaningfulToken(0);
        if (null === $searchIndex) {
            $this->insertSequence($tokens); // declaration not found, insert one

            return;
        }

        $sequenceLocation = $tokens->findSequence(
            [
                [T_DECLARE, 'declare'],
                '(',
                [T_STRING, 'strict_types'],
                '=',
                [T_LNUMBER],
                ')',
            ],
            $searchIndex,
            null,
            false,
        );

        if (null === $sequenceLocation) {
            $this->insertSequence($tokens); // declaration not found, insert one

            return;
        }

        $this->fixStrictTypesCasingAndValue($tokens, $sequenceLocation);
    }

    /**
     * @param array<int, Token> $sequence
     */
    private function fixStrictTypesCasingAndValue(Tokens $tokens, array $sequence): void
    {
        /** @var int $index */
        /** @var Token $token */
        foreach ($sequence as $index => $token) {
            if ($token->isGivenKind(T_STRING)) {
                $tokens[$index] = new Token([T_STRING, strtolower($token->getContent())]);

                continue;
            }

            if ($token->isGivenKind(T_LNUMBER)) {
                $tokens[$index] = new Token([T_LNUMBER, '1']);

                break;
            }
        }
    }

    private function insertSequence(Tokens $tokens): void
    {
        $sequence = [
            new Token([T_DECLARE, 'declare']),
            new Token('('),
            new Token([T_STRING, 'strict_types']),
            new Token('='),
            new Token([T_LNUMBER, '1']),
            new Token(')'),
            new Token(';'),
        ];
        $endIndex = count($sequence);

        $insertIndex = 1;

        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(T_DOC_COMMENT)) {
                continue;
            }

            $doc = new DocBlock($token->getContent());

            if (!count($doc->getAnnotationsOfType(['copyright']))) {
                break;
            }

            $insertIndex = $tokens->getNextMeaningfulToken($index);

            if (!$insertIndex) {
                return;
            }
        }

        $tokens->insertAt($insertIndex, $sequence);

        // start index of the sequence is always 1 here, 0 is always open tag
        // transform "<?php\n" to "<?php " if needed
        if (str_contains($tokens[0]->getContent(), "\n")) {
            $tokens[0] = new Token([$tokens[0]->getId(), trim($tokens[0]->getContent()) . ' ']);
        }

        if ($endIndex === count($tokens) - 1) {
            return; // no more tokens after sequence, single_blank_line_at_eof might add a line
        }

        $lineEnding = $this->whitespacesConfig->getLineEnding();
        if (!$tokens[1 + $endIndex]->isWhitespace()) {
            $tokens->insertAt($insertIndex + $endIndex, new Token([T_WHITESPACE, $lineEnding]));

            return;
        }

        $content = $tokens[$insertIndex + $endIndex]->getContent();
        $tokens[$insertIndex + $endIndex] = new Token([T_WHITESPACE, $lineEnding . ltrim($content, " \t")]);
    }
}
