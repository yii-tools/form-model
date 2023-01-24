<?php

declare(strict_types=1);

namespace Yii\FormModel\Tests\Support;

use Yii\FormModel\AbstractFormModel;

final class BasicForm extends AbstractFormModel
{
    private string $amount = '';
    private string $email = '';
    private string $url = '';
    private string $username = '';
    private string $server = '';
    private string $textArea = '';

    public function getHints(): array
    {
        return [
            'amount' => 'Amount hint text.',
            'email' => 'Email hint text.',
            'url' => 'Url hint text.',
        ];
    }

    public function getLabels(): array
    {
        return [
            'amount' => 'Amount label text.',
            'email' => 'Email label text.',
            'url' => 'Url label text.',
        ];
    }

    public function getPlaceholders(): array
    {
        return [
            'amount' => 'Amount placeholder text.',
            'email' => 'Email placeholder text.',
            'url' => 'Url placeholder text.',
        ];
    }
}
