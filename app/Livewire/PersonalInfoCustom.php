<?php

namespace App\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo;

class PersonalInfoCustom extends PersonalInfo
{
    protected string $view = 'livewire.personal-info-custom';

    public function mount(): void
    {
        parent::mount();
        
        // Força o carregamento do documento
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'documento' => auth()->user()->documento,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                
                TextInput::make('email')
                    ->label('E-mail')
                    ->required(),
                
                TextInput::make('documento')
                    ->label('CPF')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(function ($state) {
                        if (!$state) return null;
                        $cpf = preg_replace('/[^0-9]/', '', $state);
                        if (strlen($cpf) === 11) {
                            return substr($cpf, 0, 3) . '.' . 
                                   substr($cpf, 3, 3) . '.' . 
                                   substr($cpf, 6, 3) . '-' . 
                                   substr($cpf, 9, 2);
                        }
                        return $state;
                    }),
            ])
            ->model(auth()->user())
            ->statePath('data');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    protected function getFormActions(): array
    {
        return [];
    }
}