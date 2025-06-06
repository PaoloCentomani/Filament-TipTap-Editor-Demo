<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EmailTemplateResource\Pages;
use App\Filament\Admin\Resources\EmailTemplateResource\RelationManagers\TasksRelationManager;
use App\Filament\Support\TiptapEditor\MergeTags;
use App\Models\EmailTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;

class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;
    protected static ?string $modelLabel = 'Template E-Mail';
    protected static ?string $pluralModelLabel = 'Template E-Mail';

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(config('settings.tables.pagination.options'))
            ->defaultPaginationPageOption(config('settings.tables.pagination.default_option'))
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Oggetto')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(
                        fn (EmailTemplate $record) => tiptap_converter()->asText($record->subject),
                    ),
            ])
            ->filters([
                SelectFilter::make('task')
                    ->relationship('tasks', 'name')
                    ->label('Automatismi')
                    ->searchable()
                    ->multiple()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome del template')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('sender_name')
                    ->label('Nome del mittente')
                    ->maxLength(255)
                    ->columnSpanFull(),

                TiptapEditor::make('sender_email')
                    ->label('Email del mittente')
                    ->tools([])
                    ->disableToolbarMenus(true)
                    ->disableFloatingMenus(true)
                    ->disableBubbleMenus(true)
                    ->mergeTags(MergeTags::$tags)
                    ->maxSize(255)
                    ->output(TiptapOutput::Json)
                    ->maxContentWidth('full')
                    ->showMergeTagsInBlocksPanel(false)
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Inserisci una email o un token valido (es. {{ email_operatore }}, {{ email_utente }}, {{ email }})'),

                TiptapEditor::make('recipient_email')
                    ->label('Email del destinatario')
                    ->tools([])
                    ->disableToolbarMenus(true)
                    ->disableFloatingMenus(true)
                    ->disableBubbleMenus(true)
                    ->mergeTags(MergeTags::$tags)
                    ->maxSize(255)
                    ->output(TiptapOutput::Json)
                    ->maxContentWidth('full')
                    ->showMergeTagsInBlocksPanel(false)
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Inserisci una email o un token valido (es. {{ email_operatore }}, {{ email_utente }}, {{ email }})'),

                TiptapEditor::make('cc_recipients')
                    ->label('Destinatari CC')
                    ->tools([])
                    ->disableToolbarMenus(true)
                    ->disableFloatingMenus(true)
                    ->disableBubbleMenus(true)
                    ->mergeTags(MergeTags::$tags)
                    ->maxSize(255)
                    ->output(TiptapOutput::Json)
                    ->maxContentWidth('full')
                    ->showMergeTagsInBlocksPanel(false)
                    ->columnSpanFull()
                    ->helperText('Separa gli indirizzi email o un token valido con la virgola'),

                TiptapEditor::make('subject')
                    ->label('Oggetto')
                    ->tools([])
                    ->disableToolbarMenus(true)
                    ->disableFloatingMenus(true)
                    ->disableBubbleMenus(true)
                    ->mergeTags(MergeTags::$tags)
                    ->maxSize(255)
                    ->output(TiptapOutput::Json)
                    ->maxContentWidth('full')
                    ->showMergeTagsInBlocksPanel(false)
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Puoi usare i token (es. {{ nome }})'),

                TiptapEditor::make('body')
                    ->label('Contenuto')
                    ->tools([
                        'heading',
                        'lead',
                        'small',
                        '|',
                        '|',
                        'bold',
                        'italic',
                        'strike',
                        'underline',
                        'superscript',
                        'subscript',
                        'color',
                        'highlight',
                        '|',
                        '|',
                        'align-left',
                        'align-center',
                        'align-right',
                        '|',
                        '|',
                        'bullet-list',
                        'ordered-list',
                        'blockquote',
                        'hr',
                        'link',
                        '|',
                        '|',
                        'blocks',
                        'fullscreen',
                        'source',
                    ])
                    ->floatingMenuTools(['blocks'])
                    ->mergeTags(MergeTags::$tags)
                    ->maxSize(floor(4294967295 / 4))
                    ->output(TiptapOutput::Json)
                    ->maxContentWidth('full')
                    ->extraInputAttributes(['style' => 'min-height: 12rem;'])
                    ->required()
                    ->columnSpanFull(),

                TiptapEditor::make('signature')
                    ->label('Firma')
                    ->helperText('Lascia vuoto per utilizzare la firma dell’operatore che ha apportato l’ultima modifica.')
                    ->tools([
                        'heading',
                        'lead',
                        'small',
                        '|',
                        '|',
                        'bold',
                        'italic',
                        'strike',
                        'underline',
                        'superscript',
                        'subscript',
                        'color',
                        'highlight',
                        '|',
                        '|',
                        'align-left',
                        'align-center',
                        'align-right',
                        '|',
                        '|',
                        'bullet-list',
                        'ordered-list',
                        'blockquote',
                        'hr',
                        'link',
                        '|',
                        '|',
                        'blocks',
                        'fullscreen',
                        'source',
                    ])
                    ->floatingMenuTools(['blocks'])
                    ->mergeTags(MergeTags::$tags)
                    ->maxSize(floor(65535 / 4))
                    ->output(TiptapOutput::Json)
                    ->maxContentWidth('full')
                    ->extraInputAttributes(['style' => 'min-height: 12rem;'])
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TasksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailTemplates::route('/'),
            'create' => Pages\CreateEmailTemplate::route('/create'),
            'edit' => Pages\EditEmailTemplate::route('/{record}/edit'),
        ];
    }
}
