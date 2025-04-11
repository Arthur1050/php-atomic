// vdom.js - Sistema de Virtual DOM para renderização no cliente
const vdom = {
    // Componentes ativos no cliente
    components: new Map(),
    
    // Templates de componentes
    templates: new Map(),
    
    // Estados dos componentes
    states: new Map(),
    
    // Inicializa o VDOM
    init() {
        // Escuta eventos de montagem de componentes
        document.addEventListener('componentMount', this.handleComponentMount.bind(this));
        
        console.log('Virtual DOM inicializado.');
    },
    
    // Manipula o evento de montagem de componente
    handleComponentMount(event) {
        const componentData = event.detail;
        const element = event.target;
        
        // Armazena os metadados do componente
        this.components.set(componentData.id, {
            element: element,
            state: componentData.state,
            // type: componentData.type,
            // props: componentData.props
        });
        
        // Armazena o template
        if (!this.templates.has(componentData.type)) {
            this.templates.set(componentData.type, componentData.template);
        }
        
        // Inicializa o estado
        if (!this.states.has(componentData.id)) {
            this.states.set(componentData.id, componentData.state || {});
        }
        
        console.log(`Componente ${componentData.type} hidratado:`, componentData, this.components.get(componentData.id).element);
    },
    
    // Atualiza o estado de um componente e reenderiza
    updateComponentState(componentId, stateKey, newValue) {
        // Extrai o ID real do componente (sem o sufixo de linha específico)
        const baseParts = stateKey.split('-');
        const baseComponentId = baseParts[0]; // O ID base do componente
        
        // Recupera o estado atual
        const componentStates = this.states.get(baseComponentId) || {};
        
        // Define o novo valor no estado usando a chave específica
        componentStates[stateKey] = newValue;
        
        // Atualiza o estado no mapa
        this.states.set(baseComponentId, componentStates);
        
        // Rerrenderiza o componente
        this.renderComponent(baseComponentId);
        
        console.log(`Estado atualizado para ${baseComponentId}, chave ${stateKey}:`, newValue);
    },
    
    // Renderiza um componente com seu estado atual
    renderComponent(componentId) {
        const component = this.components.get(componentId);
        if (!component) {
            console.error(`Componente não encontrado: ${componentId}`);
            return;
        }
        
        const template = this.templates.get(component.type);
        if (!template) {
            console.error(`Template não encontrado para: ${component.type}`);
            return;
        }
        
        const componentState = this.states.get(componentId) || {};
        
        // Renderiza o componente usando o template e estado atual
        const html = this.renderTemplate(template, component.props, componentState, componentId);
        
        // Cria um elemento temporário para analisar o HTML
        const temp = document.createElement('div');
        temp.innerHTML = html;
        
        // Obtém o primeiro elemento do HTML renderizado
        const newElement = temp.firstElementChild;
        if (!newElement) {
            console.error('Erro ao renderizar componente: nenhum elemento criado');
            return;
        }
        
        // Adiciona o ID do componente ao novo elemento
        newElement.setAttribute('data-component-id', componentId);
        
        // Substitui o elemento antigo pelo novo
        component.element.parentNode.replaceChild(newElement, component.element);
        
        // Atualiza a referência do elemento
        component.element = newElement;
        this.components.set(componentId, component);
        
        console.log(`Componente ${component.type} rerenderizado`);
    },
    
    // Renderiza um template com props e estado
    renderTemplate(template, props, state, componentId) {
        // Substitui as referências de props e estado no template
        let rendered = template;
        
        // Função para obter valor do estado por chave específica
        const getStateValue = (key) => {
            // Tenta encontrar estados para este componente com este padrão de chave
            for (const [stateKey, value] of Object.entries(state)) {
                // Verifica se a chave do estado contém o padrão esperado
                if (stateKey.startsWith(componentId) && stateKey.includes(key)) {
                    return value;
                }
            }
            return undefined;
        };
        
        // Substitui marcadores de props
        for (const [key, value] of Object.entries(props)) {
            const regex = new RegExp(`\\{props\\.${key}\\}`, 'g');
            rendered = rendered.replace(regex, value);
        }
        
        // Para simplicidade, assumimos uma estrutura de template simples
        // Em um sistema real, você provavelmente usaria uma engine de template mais robusta
        
        // Processa hooks de estado
        const stateRegex = /\{\$state\.(\w+)\}/g;
        rendered = rendered.replace(stateRegex, (match, stateKey) => {
            const value = getStateValue(stateKey);
            return value !== undefined ? value : '';
        });
        
        // Substitui eventos onClick
        const clickRegex = /onClick="([^"]+)"/g;
        rendered = rendered.replace(clickRegex, (match, code) => {
            // Cria um ID único para o handler
            const handlerId = `handler_${componentId}_${Math.random().toString(36).substring(2, 9)}`;
            
            // Registra o handler no escopo global
            window[handlerId] = new Function('return ' + code)();
            
            return `onclick="window['${handlerId}']()"`;
        });
        
        return rendered;
    }
};

// Inicializa o VDOM quando o documento estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    vdom.init();
});