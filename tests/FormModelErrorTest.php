<?php

declare(strict_types=1);

namespace Yii\FormModel\Tests;

use PHPUnit\Framework\TestCase;
use Yii\FormModel\Tests\Support\BasicForm;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class FormModelErrorTest extends TestCase
{
    public function testAdd(): void
    {
        $formModel = new BasicForm();
        $errorContent = 'Invalid username.';
        $formModel->error()->add('username', $errorContent);

        $this->assertTrue($formModel->hasError('username'));
        $this->assertSame($errorContent, $formModel->getFirstError('username'));
    }

    public function testAdds(): void
    {
        $formModel = new BasicForm();
        $errorContent = ['username' => ['0' => 'Invalid username']];
        $formModel->error()->clear();

        $this->assertEmpty($formModel->getFirstError('username'));

        $formModel->error()->adds($errorContent);

        $this->assertTrue($formModel->hasError('username'));
        $this->assertSame('Invalid username', $formModel->getFirstError('username'));
    }

    public function testClear(): void
    {
        $formModel = new BasicForm();
        $formModel->error()->add('username', 'Username is required');
        $formModel->error()->add('email', 'Email is required');

        $this->assertSame(
            ['username' => ['Username is required'], 'email' => ['Email is required']],
            $formModel->error()->getAll(),
        );

        $formModel->error()->clear();

        $this->assertEmpty($formModel->error()->getAll());
    }

    public function testClearWithAttribute(): void
    {
        $formModel = new BasicForm();
        $formModel->error()->add('username', 'Username is required');
        $formModel->error()->add('email', 'Email is required');

        $this->assertSame(
            ['username' => ['Username is required'], 'email' => ['Email is required']],
            $formModel->error()->getAll(),
        );

        $formModel->error()->clear('username');

        $this->assertSame(['email' => ['Email is required']], $formModel->error()->getAll());
    }

    public function testGetAllError(): void
    {
        $formModel = new BasicForm();

        $this->assertSame([], $formModel->error()->getAll());
    }

    public function testGetError(): void
    {
        $formModel = new BasicForm();
        $formModel->error()->add('username', 'Invalid username');

        $this->assertSame(['Invalid username'], $formModel->error()->get('username'));
    }

    public function testGetErrorWithEmpty(): void
    {
        $formModel = new BasicForm();

        $this->assertSame([], $formModel->error()->get('username'));
    }

    public function testGetFirsts(): void
    {
        $formModel = new BasicForm();
        $formModel->error()->adds(
            [
                'username' => ['0' => 'Invalid username'],
                'email' => ['0' => 'Invalid email'],
            ],
        );

        $this->assertSame(
            ['username' => 'Invalid username', 'email' => 'Invalid email'],
            $formModel->error()->getFirsts(),
        );
    }

    public function testGetFirstError(): void
    {
        $formModel = new BasicForm();

        $this->assertSame('', $formModel->getFirstError('username'));
    }

    public function testGetFirstsErrorWithEmpty(): void
    {
        $formModel = new BasicForm();

        $this->assertSame([], $formModel->error()->getFirsts());
    }

    public function testGetSummary(): void
    {
        $formModel = new BasicForm();
        $formModel->error()->adds(
            [
                'username' => ['0' => 'Invalid username'],
                'email' => ['0' => 'Invalid email'],
            ],
        );

        $this->assertSame(['Invalid username', 'Invalid email'], $formModel->error()->getSummary());
    }

    public function testGetSummaryWithEmpty(): void
    {
        $formModel = new BasicForm();

        $this->assertSame([], $formModel->error()->getSummary());
    }

    public function testGetSummaryWithOnlyAttributes(): void
    {
        $formModel = new BasicForm();
        $formModel->error()->adds(
            [
                'username' => ['0' => 'Invalid username'],
                'email' => ['0' => 'Invalid email'],
            ],
        );

        $this->assertSame(['Invalid username'], $formModel->error()->getSummary(['username']));
    }

    public function testGetSummaryFirst(): void
    {
        $formModel = new BasicForm();
        $formModel->error()->adds(
            [
                'username' => ['0' => 'The field is required', '1' => 'Invalid username'],
                'email' => ['0' => 'Invalid email'],
            ],
        );

        $this->assertSame(
            ['username' => 'The field is required', 'email' => 'Invalid email'],
            $formModel->error()->getSummaryFirst(),
        );
    }

    public function testHasError(): void
    {
        $formModel = new BasicForm();

        $this->assertFalse($formModel->hasError());
    }

    public function testHasErrorWithAttribute(): void
    {
        $formModel = new BasicForm();
        $formModel->error()->add('username', 'Invalid username');

        $this->assertTrue($formModel->hasError('username'));
    }
}
