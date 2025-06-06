<?php

namespace App\Filament\Admin\Resources\EmailTemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';
    protected static ?string $title = 'Automatismi';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome'),
            ])
            ->defaultSort('tasks.created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordTitleAttribute('name'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
