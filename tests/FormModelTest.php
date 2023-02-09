<?php

declare(strict_types=1);

namespace Yii\FormModel\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\FormModel\AbstractFormModel;
use Yii\FormModel\Tests\Support\BasicForm;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class FormModelTest extends TestCase
{
    public function testGenerateLabel(): void
    {
        $formModel = new BasicForm();

        $this->assertSame('Server', $formModel->getLabel('server'));
    }

    public function testGetHint(): void
    {
        $formModel = new BasicForm();

        $this->assertSame('Amount hint text.', $formModel->getHint('amount'));
    }

    public function testGetHints(): void
    {
        $formModel = new BasicForm();

        $this->assertSame(
            [
                'amount' => 'Amount hint text.',
                'email' => 'Email hint text.',
                'url' => 'Url hint text.',
            ],
            $formModel->getHints()
        );
    }

    public function testGetHintsWithEmpty(): void
    {
        $formModel = new class () extends AbstractFormModel {
            private string $amount = '';
        };

        $this->assertSame([], $formModel->getHints());
    }

    public function testGetHintException(): void
    {
        $formModel = new BasicForm();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Attribute 'noExist' does not exist.");

        $this->assertSame('', $formModel->getHint('noExist'));
    }

    public function testGetLabel(): void
    {
        $formModel = new BasicForm();

        $this->assertSame('Amount label text.', $formModel->getLabel('amount'));
    }

    public function testGetLabels(): void
    {
        $formModel = new BasicForm();

        $this->assertSame(
            [
                'amount' => 'Amount label text.',
                'email' => 'Email label text.',
                'url' => 'Url label text.',
            ],
            $formModel->getLabels()
        );
    }

    public function testGetLabelsWithEmpty(): void
    {
        $formModel = new class () extends AbstractFormModel {
            private string $amount = '';
        };

        $this->assertSame([], $formModel->getLabels());
    }

    public function testGetLabelException(): void
    {
        $formModel = new BasicForm();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Attribute 'noExist' does not exist.");

        $formModel->getLabel('noExist');
    }

    public function testGetPlaceholder(): void
    {
        $formModel = new BasicForm();

        $this->assertSame('Amount placeholder text.', $formModel->getPlaceholder('amount'));
    }

    public function testGetPlaceholders(): void
    {
        $formModel = new BasicForm();

        $this->assertSame(
            [
                'amount' => 'Amount placeholder text.',
                'email' => 'Email placeholder text.',
                'url' => 'Url placeholder text.',
            ],
            $formModel->getPlaceholders()
        );
    }

    public function testGetPlaceholdersWithEmpty(): void
    {
        $formModel = new class () extends AbstractFormModel {
            private string $amount = '';
        };

        $this->assertSame([], $formModel->getPlaceholders());
    }

    public function testGetPlaceholderException(): void
    {
        $formModel = new BasicForm();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Attribute 'noExist' does not exist.");

        $formModel->getPlaceholder('noExist');
    }

    public function testGetRuleHtmlAttributes(): void
    {
        $formModel = new BasicForm();

        $this->assertSame([], $formModel->getRuleHtmlAttributes($formModel, 'amount'));
    }
}
