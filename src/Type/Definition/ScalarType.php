<?php

declare(strict_types=1);

namespace GraphQL\Type\Definition;

use GraphQL\Language\AST\ScalarTypeDefinitionNode;
use GraphQL\Language\AST\ScalarTypeExtensionNode;
use GraphQL\Language\AST\TypeDefinitionNode;
use GraphQL\Utils\Utils;

use function is_string;

/**
 * Scalar Type Definition
 *
 * The leaf values of any request and input values to arguments are
 * Scalars (or Enums) and are defined with a name and a series of coercion
 * functions used to ensure validity.
 *
 * Example:
 *
 * class OddType extends ScalarType
 * {
 *     public $name = 'Odd',
 *     public function serialize($value)
 *     {
 *         return $value % 2 === 1 ? $value : null;
 *     }
 * }
 */
abstract class ScalarType extends Type implements OutputType, InputType, LeafType, NullableType, NamedType
{
    /** @var ScalarTypeDefinitionNode|null */
    public ?TypeDefinitionNode $astNode;

    /** @var array<ScalarTypeExtensionNode> */
    public array $extensionASTNodes;

    /**
     * @param mixed[] $config
     */
    public function __construct(array $config = [])
    {
        $this->name              = $config['name'] ?? $this->tryInferName();
        $this->description       = $config['description'] ?? $this->description ?? null;
        $this->astNode           = $config['astNode'] ?? null;
        $this->extensionASTNodes = $config['extensionASTNodes'] ?? [];
        $this->config            = $config;

        Utils::invariant(is_string($this->name), 'Must provide name.');
    }
}
