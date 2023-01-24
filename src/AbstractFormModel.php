<?php

declare(strict_types=1);

namespace Yii\FormModel;

use InvalidArgumentException;
use Yii\Model\AbstractModel;
use Yiisoft\Strings\Inflector;
use Yiisoft\Strings\StringHelper;

use function array_key_exists;

abstract class AbstractFormModel extends AbstractModel
{
    private FormModelError $formModelError;

    public function __construct()
    {
        $this->formModelError = new FormModelError();

        parent::__construct();
    }

    /**
     * @return FormModelError The form model error instance.
     */
    public function error(): FormModelError
    {
        return $this->formModelError;
    }

    /**
     * @param string $attribute The attribute name.
     *
     * @return string The error message. Empty string is returned if there is no error.
     */
    public function getFirstError(string $attribute): string|null
    {
        return $this->formModelError->getFirst($attribute);
    }

    /**
     * @param string $attribute The attribute name.
     *
     * @return string The text hint for the specified attribute.
     */
    public function getHint(string $attribute): string
    {
        $nestedHint = $this->getNestedValue('getHint', $attribute);

        return match ($this->has($attribute)) {
            true => $nestedHint === '' ? $this->getInternalHint($attribute) : $nestedHint,
            false => throw new InvalidArgumentException("Attribute '$attribute' does not exist."),
        };
    }

    /**
     * @return array Allows to define hints for the form model attributes in associative array format.
     *
     * ```php
     * [
     *     'attributeName' => 'attributeHint',
     * ]
     * ```
     *
     * @psalm-return string[]
     */
    public function getHints(): array
    {
        return [];
    }

    /**
     * @return string The label for the specified attribute. If the attribute does not have a label, a label is
     * generated using {@see generateLabel()}.
     */
    public function getLabel(string $attribute): string
    {
        $nestedLabel = $this->getNestedValue('getLabel', $attribute);

        return match ($this->has($attribute)) {
            true => $nestedLabel === '' ? $this->getInternalLabel($attribute) : $nestedLabel,
            false => throw new InvalidArgumentException("Attribute '$attribute' does not exist."),
        };
    }

    /**
     * @return array Allows to define labels for the form model attributes in associative array format.
     *
     * ```php
     * [
     *     'attributeName' => 'attributeLabel',
     * ]
     *
     * @psalm-return string[]
     */
    public function getLabels(): array
    {
        return [];
    }

    /**
     * @param string $attribute The attribute name.
     *
     * @return string The text placeholder for the specified attribute.
     */
    public function getPlaceholder(string $attribute): string
    {
        $nestedPlaceholder = $this->getNestedValue('getPlaceholder', $attribute);

        return match ($this->has($attribute)) {
            true => $nestedPlaceholder === '' ? $this->getInternalPlaceholder($attribute) : $nestedPlaceholder,
            false => throw new InvalidArgumentException("Attribute '$attribute' does not exist."),
        };
    }

    /**
     * @return array Allows to define placeholders for the form model attributes in associative array format.
     *
     * ```php
     * [
     *     'attributeName' => 'attributePlaceholder',
     * ]
     * ```
     *
     * @psalm-return string[]
     */
    public function getPlaceholders(): array
    {
        return [];
    }

    /**
     * Wheather the form model has errors for the specified attribute, or any attribute if the attribute name is not
     * specified.
     *
     * @param string|null $attribute The attribute name.
     *
     * @return bool Wheather the form model has errors for the specified attribute, or any attribute if the attribute
     * name is not specified.
     */
    public function hasError(string $attribute = null): bool
    {
        return $this->formModelError->has($attribute);
    }

    /**
     * Generates a user-friendly attribute label based on the give attribute name.
     *
     * This is done by replacing underscores, dashes and dots with blanks and changing the first letter of each word to
     * upper case.
     *
     * For example, 'department_name' or 'DepartmentName' will generate 'Department Name'.
     *
     * @param string $name The column name.
     *
     * @return string The attribute label.
     */
    private function generateLabel(string $name): string
    {
        $inflector = new Inflector();

        return StringHelper::uppercaseFirstCharacterInEachWord($inflector->toWords($name));
    }

    /**
     * Returns the hint for the specified attribute, or an empty string if the attribute does not have a hint.
     *
     * @param string $attribute The attribute name.
     *
     * @return string The text hint for the specified attribute.
     */
    private function getInternalHint(string $attribute): string
    {
        $hint = '';
        $hints = $this->getHints();

        if (array_key_exists($attribute, $hints)) {
            $hint = $hints[$attribute];
        }

        return $hint;
    }

    /**
     * Returns the label for the specified attribute. If the attribute does not have a label, a label is generated using
     * {@see generateLabel()}.
     *
     * @param string $attribute The attribute name.
     *
     * @return string The label for the specified attribute.
     */
    private function getInternalLabel(string $attribute): string
    {
        $label = $this->generateLabel($attribute);
        $labels = $this->getLabels();

        if (array_key_exists($attribute, $labels)) {
            $label = $labels[$attribute];
        }

        return $label;
    }

    /**
     * Returns the placeholder for the specified attribute. If the attribute does not have a placeholder, an empty
     * string is returned.
     *
     * @param string $attribute The attribute name.
     *
     * @return string The text placeholder for the specified attribute.
     */
    private function getInternalPlaceholder(string $attribute): string
    {
        $placeholder = '';
        $placeholders = $this->getPlaceholders();

        if (array_key_exists($attribute, $placeholders)) {
            $placeholder = $placeholders[$attribute];
        }

        return $placeholder;
    }
}