<?php

namespace App\Filament\Cliente\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getDocumentoFormComponent(),
                $this->getRoleFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getDocumentoFormComponent(): Component
    {
        return TextInput::make('documento')
            ->label('CPF')
            ->required()
            ->mask('999.999.999-99')
            ->length(14)
            ->unique($this->getUserModel())
            ->placeholder('000.000.000-00')
            ->helperText('Informe apenas os números do CPF')
            ->rule('regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/');
    }

    protected function getRoleFormComponent(): Component
    {
        return Select::make('role')
            ->label('Tipo de Usuário')
            ->options([
                'cliente' => 'Cliente',
                'admin' => 'Administrador',
                'vendedor' => 'Vendedor'
            ])
            ->default('cliente')
            ->required()
            ->native(false);
    }

    /**
     * Remove a formatação do CPF antes de salvar
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        // Remove pontos e traços do CPF
        if (isset($data['documento'])) {
            $data['documento'] = preg_replace('/[^0-9]/', '', $data['documento']);
        }

        return $data;
    }
}
