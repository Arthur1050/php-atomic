<?php
use Arthurspar\Atomic\Components\Button;
use Arthurspar\Atomic\Components\Counter;

require_once './vendor/autoload.php';

echo new Counter(
    label: "Contador",
    value: 0
);

echo new Button(
    label: "Ação",
    type: Button::TYPE_PRIMARY
);