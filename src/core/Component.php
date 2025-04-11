<?php
namespace Arthurspar\Atomic\Core;

abstract class Component {
    private ?\Dom\HTMLDocument $_dom = null;
    protected array $props = [];
    private static int $idCounter = 0;
    private string $componentId;
    
    // Gerenciamento de componentes estático
    // private static array $componentsRegistry = [];
    private static bool $coreScriptInjected = false;

    protected ?\Dom\Element $dom
    {
        get {
            if ($this->_dom === null) {
                $this->_dom = \Dom\HTMLDocument::createFromString($this->html(), LIBXML_NOERROR);
                return $this->_dom->body->firstElementChild;
            }
            return $this->_dom->body->firstElementChild;
        }
        set => throw new \Exception('Cannot set dom property');
    }

    public function getComponentMetadata(): array {
        // Aqui você pode adicionar qualquer metadado que deseja expor para o JavaScript
        // Exemplo: ID do componente, estado inicial, etc.
        return [
            'id' => $this->componentId,
            'state' => [],
            'type' => get_class($this),
        ];
    }

    public function getDispatchComponentMount(): string {
        $componentDataJson = json_encode($this->getComponentMetadata());

        return <<<JS
            <script>
                (function() {
                    // Aguardamos o DOM estar pronto
                    document.addEventListener('DOMContentLoaded', function() {
                        // Obtenção seletiva do elemento baseado no atributo data-component-id
                        const element = document.querySelector('[data-component-id="{$this->componentId}"]');
                        if (element) {
                            // Criamos um evento customizado com os metadados do componente
                            const componentEvent = new CustomEvent('componentMount', {
                                detail: {$componentDataJson},
                                bubbles: true
                            });
                            
                            element.addEventListener('componentMount', function(event) {
                                // Aqui você pode manipular o evento, se necessário
                                console.log('Componente montado:', event.detail);
                            });

                            // Disparamos o evento no elemento
                            element.dispatchEvent(componentEvent);
                        }
                    });
                })();
            </script>
        JS;
    }

    public function getCoreScript(): string {
        return file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/src/core/core.js") ?? "";
    }

    public function render(): string {
        // Gera um ID único para cada componente
        $this->componentId = 'component-' . self::$idCounter++;
        // Adiciona o ID ao elemento raiz do componente
        $this->dom->setAttribute('data-component-id', $this->componentId);

        // Por falta do outerHTML, usamos o innerHTML
        $html = $this->dom->parentElement->innerHTML;
        
        // Adiciona o script de núcleo apenas uma vez por página
        if (!self::$coreScriptInjected) {
            $coreScript = $this->getCoreScript();
            $html .= "<script>{$coreScript}</script>";
            self::$coreScriptInjected = true;
        }
        
        return $html . $this->getDispatchComponentMount();
    }

    abstract protected function html(): string;

    public function __toString() {
        return $this->render();
    }
}