<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Livewire;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('File')->translateLabel()
                ->relationship('file')
                ->saveRelationshipsWhenHidden()
                ->schema([
                    Forms\Components\FileUpload::make('file_id')->translateLabel()
                    ->required()
                    ->image()
                    ->maxSize(2048)
                    ->directory('uploads')
                    ->getUploadedFileNameForStorageUsing(function (Livewire\TemporaryUploadedFile $file): string {
                        return time() . '_' . $file->getClientOriginalName();
                }),
                ]),
                Forms\Components\Fieldset::make('Post')->translateLabel()
                    ->schema([
                        Forms\Components\Hidden::make('file_id'),
                        Forms\Components\Select::make('author_id')->translateLabel()
                                                ->relationship('user', 'name')
                                                ->searchable()      
                                                ->default(\Auth::user()->id)
                                                ->required(),
                        Forms\Components\Select::make('visibility_id')->translateLabel()
                        ->relationship('visibilities', 'name')
                        ->searchable()      
                        ->required(),                        
                        Forms\Components\RichEditor::make('body')->translateLabel()
                                                    ->toolbarButtons([
                                                        'blockquote',
                                                        'bold',
                                                        'bulletList',
                                                        'codeBlock',
                                                        'h2',
                                                        'h3',
                                                        'italic',
                                                        'link',
                                                        'orderedList',
                                                        'redo',
                                                        'strike',
                                                        'underline',
                                                        'undo',
                                                    ])->required()
                                                    ->maxLength(255),
                        Forms\Components\TextInput::make('latitude')->translateLabel()
                                                    ->numeric()
                                                    ->required(),
                        Forms\Components\TextInput::make('longitude')->translateLabel()
                                                    ->numeric()
                                                    ->required(),
                                                ]),
            ]);
    }
    
 
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file.filepath')->square()->width(100)->height(100)->translateLabel(),
                Tables\Columns\TextColumn::make('author_id')->translateLabel(),
                Tables\Columns\TextColumn::make('body')->translateLabel(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }    
}
