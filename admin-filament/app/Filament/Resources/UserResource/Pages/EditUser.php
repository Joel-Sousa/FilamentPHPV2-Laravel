<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('change_password')
                ->form([
                    TextInput::make('password')
                        // TextInput::make('password')
                        ->required()
                        ->password(),
                        TextInput::make('password_confirmation')
                        ->password()
                        ->required()
                        ->same('password')
                        ->password(),
                ])
                ->action(function (array $data){
                    $this->record->update([
                        'password' => Hash::make($data['password'])
                    ]);
                    $this->notify('success', 'Senha alterada');
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
