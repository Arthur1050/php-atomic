<?
namespace Arthurspar\Atomic\Components;

use Arthurspar\Atomic\Core\Component;
use Arthurspar\Atomic\Core\Hooks;

class Counter extends Component {
    public function __construct(
        private string $label,
        private int $value = 0
    ) {}

    public function html(): string {
        $addButton = new Button("+", Button::TYPE_PRIMARY);
        $minusButton = new Button("-", Button::TYPE_PRIMARY);

        [$get, $set] = Hooks::useState($this->value);

        return <<<HTML
            <div class="d-flex flex-column gap-2">
                <span>{$this->label}: {$get}</span>
                <div class="d-flex gap-2">
                    {$addButton}
                    {$minusButton}
                </div>
            </div>
        HTML;
    }
}