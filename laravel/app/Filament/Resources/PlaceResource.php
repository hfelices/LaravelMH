<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Filament\Resources\PlaceResource\RelationManagers;
use App\Models\Place;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Forms\Components\FileUpload;
use Livewire\TemporaryUploadedFile;
use  Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use App\Models\User;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('File')
                ->translateLabel()
                ->relationship('file')
                ->saveRelationshipsWhenHidden()
                ->schema([
                    Forms\Components\FileUpload::make('file_id')
                    ->required()
                    ->image()
                    ->maxSize(2048)
                    ->directory('uploads')
                    ->getUploadedFileNameForStorageUsing(function (\Livewire\TemporaryUploadedFile $file): string {
                        return time() . '_' . $file->getClientOriginalName();
                    }),
                ]),
                Forms\Components\Fieldset::make('Place')
                ->translateLabel()
                ->schema([
                Forms\Components\Hidden::make('file_id'),
                Forms\Components\Select::make('author_id')
                ->translateLabel()
                ->label('Author')
                ->relationship('user', 'name')
                ->searchable()
                ->default(\Auth::user()->id)
                ->required(),
                    // ->relationship('user', 'name')
                    // ->required(),
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                ->translateLabel()
                    ->toolbarButtons([
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'edit',
                        'italic',
                        'link',
                        'orderedList',
                        'preview',
                        'strike',
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                ->translateLabel()
                    ->required(),
                Forms\Components\TextInput::make('longitude')
                ->translateLabel()
                    ->required(),
                    ])
            ]);
     

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_id')->translateLabel(),
                Tables\Columns\TextColumn::make('author_id')->translateLabel(),
                Tables\Columns\TextColumn::make('name')->translateLabel(),
                Tables\Columns\TextColumn::make('description')->translateLabel(),
                Tables\Columns\TextColumn::make('latitude')->translateLabel(),
                Tables\Columns\TextColumn::make('longitude')->translateLabel(),
                Tables\Columns\TextColumn::make('created_at')->translateLabel()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->translateLabel()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'view' => Pages\ViewPlace::route('/{record}'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }    
}
