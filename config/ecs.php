<?php

declare(strict_types=1);

use JustCoded\PhpCsFixer\Fixers\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoAliasLanguageConstructCallFixer;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\Basic\BracesPositionFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Basic\NoMultipleStatementsPerLineFixer;
use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\Basic\SingleLineEmptyBodyFixer;
use PhpCsFixer\Fixer\Casing\ConstantCaseFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\Casing\LowercaseStaticReferenceFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfStaticAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\LambdaNotUsedImportFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareParenthesesFixer;
use PhpCsFixer\Fixer\LanguageConstruct\SingleSpaceAroundConstructFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLinesBeforeNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\CleanNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\NewWithParenthesesFixer;
use PhpCsFixer\Fixer\Operator\StandardizeIncrementFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocTagRenameFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocInlineTagNormalizerFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSummaryFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\ReturnNotation\SimplifiedNullReturnFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\StringNotation\NoBinaryStringFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use PhpCsFixer\Fixer\Whitespace\SpacesInsideParenthesesFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\TypeDeclarationSpacesFixer;
use PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer;
use PhpCsFixerCustomFixers\Fixer\NoDuplicatedImportsFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;
use SlevomatCodingStandard\Sniffs\Arrays\MultiLineArrayEndBracketPlacementSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\DeadCatchSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\RequireNonCapturingCatchSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\NullTypeHintOnLastPositionSniff;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->cacheDirectory(sys_get_temp_dir() . '/ecs');

    $ecsConfig->sets([SetList::ARRAY]);

    $ecsConfig->ruleWithConfiguration(LineLengthFixer::class, [
        LineLengthFixer::LINE_LENGTH => 120,
        LineLengthFixer::INLINE_SHORT_LINES => false,
    ]);

    $ecsConfig->rules([
        BinaryOperatorSpacesFixer::class,
        BlankLineAfterNamespaceFixer::class,
        BlankLineAfterOpeningTagFixer::class,
        CastSpacesFixer::class,
        ClassDefinitionFixer::class,
        CleanNamespaceFixer::class,
        ConstantCaseFixer::class,
        DeadCatchSniff::class,
        DeclareStrictTypesFixer::class,
        ElseifFixer::class,
        EncodingFixer::class,
        ExplicitStringVariableFixer::class,
        FullOpeningTagFixer::class,
        FullyQualifiedStrictTypesFixer::class,
        FunctionDeclarationFixer::class,
        GeneralPhpdocTagRenameFixer::class,
        GlobalNamespaceImportFixer::class,
        HeredocToNowdocFixer::class,
        IndentationTypeFixer::class,
        IntegerLiteralCaseFixer::class,
        LambdaNotUsedImportFixer::class,
        LineEndingFixer::class,
        ListSyntaxFixer::class,
        LowercaseCastFixer::class,
        LowercaseKeywordsFixer::class,
        LowercaseStaticReferenceFixer::class,
        MagicConstantCasingFixer::class,
        MagicMethodCasingFixer::class,
        MethodChainingIndentationFixer::class,
        MultiLineArrayEndBracketPlacementSniff::class,
        MultilinePromotedPropertiesFixer::class,
        NativeFunctionCasingFixer::class,
        NativeTypeDeclarationCasingFixer::class,
        NoAliasFunctionsFixer::class,
        NoAliasLanguageConstructCallFixer::class,
        NoAlternativeSyntaxFixer::class,
        NoBinaryStringFixer::class,
        NoBlankLinesAfterClassOpeningFixer::class,
        NoBlankLinesAfterPhpdocFixer::class,
        NoBreakCommentFixer::class,
        NoClosingTagFixer::class,
        NoDuplicatedImportsFixer::class,
        NoEmptyPhpdocFixer::class,
        NoEmptyStatementFixer::class,
        NoLeadingImportSlashFixer::class,
        NoLeadingNamespaceWhitespaceFixer::class,
        NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
        NoSpacesAfterFunctionNameFixer::class,
        SpacesInsideParenthesesFixer::class,
        NoTrailingWhitespaceFixer::class,
        NoTrailingWhitespaceInCommentFixer::class,
        NoUnusedImportsFixer::class,
        NoUselessElseFixer::class,
        NoWhitespaceBeforeCommaInArrayFixer::class,
        NullTypeHintOnLastPositionSniff::class,
        PhpdocIndentFixer::class,
        PhpdocInlineTagNormalizerFixer::class,
        PhpdocNoAccessFixer::class,
        PhpdocNoUselessInheritdocFixer::class,
        PhpdocScalarFixer::class,
        RequireNonCapturingCatchSniff::class,
        ReturnTypeDeclarationFixer::class,
        SelfStaticAccessorFixer::class,
        ShortScalarCastFixer::class,
        SingleBlankLineAtEofFixer::class,
        SingleImportPerStatementFixer::class,
        SingleLineAfterImportsFixer::class,
        SingleLineEmptyBodyFixer::class,
        SingleQuoteFixer::class,
        StandardizeIncrementFixer::class,
        StringableInterfaceFixer::class,
        SwitchCaseSemicolonToColonFixer::class,
        SwitchCaseSpaceFixer::class,
        TernaryOperatorSpacesFixer::class,
        TypeDeclarationSpacesFixer::class,
        UnaryOperatorSpacesFixer::class,
        VisibilityRequiredFixer::class,
        WhitespaceAfterCommaInArrayFixer::class,
    ]);

    $ecsConfig->ruleWithConfiguration(DeclareEqualNormalizeFixer::class, ['space' => 'none']);

    // split of BracesFixer in PHP CS Fixer 3.10 - https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/4884
    $ecsConfig->rules([
        ControlStructureBracesFixer::class,
        NoMultipleStatementsPerLineFixer::class,
        DeclareParenthesesFixer::class,
        ControlStructureContinuationPositionFixer::class,
        StatementIndentationFixer::class,
        SingleSpaceAroundConstructFixer::class,
    ]);
    $ecsConfig->ruleWithConfiguration(BracesPositionFixer::class, [
        'anonymous_classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
    ]);

    $ecsConfig->ruleWithConfiguration(NewWithParenthesesFixer::class, [
        'anonymous_class' => false,
    ]);

    $ecsConfig->ruleWithConfiguration(VisibilityRequiredFixer::class, [
        'elements' => ['const', 'method', 'property'],
    ]);

    $ecsConfig->ruleWithConfiguration(MethodArgumentSpaceFixer::class, [
        'on_multiline' => 'ensure_fully_multiline',
    ]);

    $ecsConfig->ruleWithConfiguration(SingleClassElementPerStatementFixer::class, [
        'elements' => ['property'],
    ]);

    $ecsConfig->ruleWithConfiguration(ConcatSpaceFixer::class, [
        'spacing' => 'one',
    ]);

    $ecsConfig->ruleWithConfiguration(OrderedImportsFixer::class, [
        'sort_algorithm' => 'alpha',
        'imports_order' => ['class', 'function', 'const'],
    ]);

    $ecsConfig->ruleWithConfiguration(NoMixedEchoPrintFixer::class, ['use' => 'echo']);

    $ecsConfig->ruleWithConfiguration(BlankLineBeforeStatementFixer::class, [
        'statements' => [
            'continue',
            'return',
            'foreach',
            'if',
            'switch',
            'try',
            'throw',
            'while',
            'yield',
            'yield_from',
        ],
    ]);

    $ecsConfig->ruleWithConfiguration(BlankLinesBeforeNamespaceFixer::class, [
        'min_line_breaks' => 2,
        'max_line_breaks' => 2,
    ]);

    $ecsConfig->ruleWithConfiguration(TrailingCommaInMultilineFixer::class, [
        'elements' => ['arrays', 'arguments', 'parameters'],
    ]);

    $ecsConfig->ruleWithConfiguration(FunctionDeclarationFixer::class, [
        'closure_fn_spacing' => 'none',
    ]);

    // Disabled as has issues.
    //$ecsConfig->ruleWithConfiguration(UnusedVariableSniff::class, [
    //    'ignoreUnusedValuesWhenOnlyKeysAreUsedInForeach' => true,
    //]);

    $ecsConfig->ruleWithConfiguration(MultilineWhitespaceBeforeSemicolonsFixer::class, ['strategy' => 'no_multi_line']);

    $ecsConfig->ruleWithConfiguration(PhpdocOrderFixer::class, [
        'order' => ['param', 'var', 'return', 'throws', 'since', 'author', 'deprecated', 'internal', 'todo'],
    ]);

    $ecsConfig->ruleWithConfiguration(ClassAttributesSeparationFixer::class, [
        'elements' => [
            'const' => 'none',
            'method' => 'one',
            'property' => 'one',
            'trait_import' => 'none',
        ],
    ]);

    $baseSkipPaths = [
        '_ide_helper*.php',
        '.phpstorm.meta.php',
        '*.blade.php',

        'bootstrap/cache',
        'src/bootstrap/cache',
        'src/admin/bootstrap/cache',
        'src/api/bootstrap/cache',
        'boilerplate/src/admin/bootstrap/cache',
        'boilerplate/src/api/bootstrap/cache',

        'build',
        'src/build',
        'boilerplate/build',

        'runtime',
        'src/runtime',
        'boilerplate/runtime',

        'node_modules',
        'src/node_modules',
        'src/admin/node_modules',
        'src/api/node_modules',
        'boilerplate/src/admin/node_modules',
        'boilerplate/src/api/node_modules',

        'storage',
        'src/storage',
        'boilerplate/src/storage',

        'vendor',
        'src/vendor',
        'boilerplate/src/vendor',

        'var',
        'src/var',
    ];

    $skipPaths = [];
    foreach (['codebase/', './', ''] as $prefix) {
        foreach ($baseSkipPaths as $skipPath) {
            $skipPaths[] = "{$prefix}$skipPath";
        }
    }

    $ecsConfig->skip([
        PhpdocSummaryFixer::class,
        PhpdocToCommentFixer::class,
        PsrAutoloadingFixer::class,
        SelfAccessorFixer::class,
        SimplifiedNullReturnFixer::class,
        StatementIndentationFixer::class,
        UnaryOperatorSpacesFixer::class,
        ArrayOpenerAndCloserNewlineFixer::class,
        ArrayListItemNewlineFixer::class,
        StandaloneLineInMultilineArrayFixer::class,
        NoAliasLanguageConstructCallFixer::class,

        ...$skipPaths,
    ]);
};
