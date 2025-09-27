## Documentação: História de Usuário 1

Nome da História

Cadastro e Configuração de Alertas

Objetivo (Conforme Especificado)

Como investidor, eu quero me cadastrar na plataforma e configurar um alerta para uma ação específica, definindo o range de preço que me interessa, para que eu não perca a oportunidade de negociar.

## Escopo / Funcionalidade Entregue
<img width="680" height="403" alt="Image" src="https://github.com/user-attachments/assets/e3f90bc8-3d4d-4382-a4a7-3f9ee6a42e16" />

## Instruções Chave para o Desenvolvimento

Esta funcionalidade reside principalmente em dois locais:

    Modelo App\Models\User.php: 
        Contém a relação public function alerts() { return $this->hasMany(Alert::class); }.
        
    Componente App\Livewire\CreateAlert.php:
        Propriedades: $stock_symbol, $min_price, $max_price.

    Método save(): Utiliza auth()->user()->alerts()->create([...]) para salvar os dados com segurança e
        dispara o evento ($this->dispatch('alert-saved')) para atualizar o estado da sessão e mostrar a mensagem de sucesso.
        
    Validação Crítica: max_price' => 'required|numeric|gt:min_price'.
