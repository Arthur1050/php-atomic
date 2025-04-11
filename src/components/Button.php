<?
namespace Arthurspar\Atomic\Components;

use Arthurspar\Atomic\Core\Component;

class Button extends Component {
    public function __construct(
        private string $label,
        private int $type = self::TYPE_PRIMARY
    ) {}

    public const TYPE_PRIMARY = 1;
    public const TYPE_SECONDARY = 2;
    public const TYPE_TERTIARY = 3;

    public function html(): string {
        return <<<HTML
            <button class="btn btn-primary">{$this->label}</button>
        HTML;
    }
}