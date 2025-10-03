## 📄 Documentação do Projeto: Avisa Ação (MVP)

Este documento detalha o que foi construído durante a implementação das Histórias de Usuário iniciais, focando na base de autenticação e no sistema de cadastro e listagem de alertas.

### 🛠️ Tecnologias Utilizadas

| Tecnologia | Finalidade |
| :--- | :--- |
| **Laravel 10+** | Framework PHP base para toda a aplicação. |
| **Laravel Jetstream** | Autenticação, Login, Registro e Layout do Dashboard (Frontend Kit). |
| **Livewire** | Desenvolvimento reativo e dinâmico dos componentes de UI (`CreateAlert`, `ListAlerts`). |
| **Tailwind CSS** | Estilização (design) do frontend. |
| **SQLite** | Banco de dados local para desenvolvimento. |

---

## 🎯 História de Usuário 1: Cadastro e Configuração de Alertas

**Objetivo:** Permitir que o usuário se cadastre e configure um alerta de preço.

### Detalhes da Implementação

| Recurso | Descrição | Arquivos Chave |
| :--- | :--- | :--- |
| **Estrutura** | Criação do **Modelo `Alert`** e da tabela `alerts` no banco de dados. | `app/Models/Alert.php`<br>`database/migrations/*_create_alerts_table.php` |
| **Relações** | Definida a relação **`hasMany`** no `User` e **`belongsTo`** no `Alert` para garantir que cada alerta esteja vinculado a um usuário. | `app/Models/User.php` |
| **Formulário** | Componente Livewire para criação de novos alertas, implementado com **Jetstream/Tailwind** para design. | `app/Livewire/CreateAlert.php`<br>`resources/views/livewire/create-alert.blade.php` |
| **Validação** | Regras de validação do Laravel (ex: `required`, `numeric`), com destaque para a regra **`gt:min_price`** para garantir que o preço máximo seja maior que o mínimo. | `app/Livewire/CreateAlert.php` |

---

## 📊 História de Usuário 2: Visualização e Gestão de Alertas

**Objetivo:** Permitir que o usuário visualize e exclua seus alertas ativos no painel.

### Detalhes da Implementação

| Recurso | Descrição | Arquivos Chave |
| :--- | :--- | :--- |
| **Listagem** | Criação do componente **Livewire `ListAlerts`** para buscar e exibir os dados. | `app/Livewire/ListAlerts.php`<br>`resources/views/livewire/list-alerts.blade.php` |
| **Busca** | Uso do `auth()->user()->alerts()` no método `render()` para garantir o escopo de dados apenas para o usuário logado. | `app/Livewire/ListAlerts.php` |
| **Paginação** | Implementação da paginação via *trait* `Livewire\WithPagination` para performance (`10 itens/página`). | `app/Livewire/ListAlerts.php` |
| **Exclusão** | Método **`deleteAlert($id)`** com verificação de propriedade para segurança. O botão usa a diretiva `wire:confirm`. | `app/Livewire/ListAlerts.php` |
| **Comunicação** | Uso de **Eventos Livewire (`alertSaved`)** para garantir a atualização imediata da lista (`ListAlerts` usa `$listeners = ['alertSaved' => '$refresh']`) após a criação de um alerta em `CreateAlert`. | `app/Livewire/CreateAlert.php`<br>`app/Livewire/ListAlerts.php` |
