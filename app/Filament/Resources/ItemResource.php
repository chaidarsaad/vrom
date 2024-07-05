<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Closure;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->unique(ignoreRecord: true)
                    ->afterStateUpdated(function (Set $set, $state) {
                        // Check if $state is not null before generating the slug
                        if ($state !== null && $state !== '') {
                            $set('slug', Item::generateUniqueSlug($state));
                        } else {
                            // Optionally, set a default slug or handle the empty case
                            $set('slug', ''); // or handle as needed
                        }
                    })
                    ->required()
                    ->live(onBlur: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->placeholder('otomatis terisi')
                    ->readOnly()
                    ->required()
                    ->afterStateUpdated(function (Closure $set) {
                        $set('slug', Item::generateUniqueSlug($state));
                    })
                    ->maxLength(255),
                Forms\Components\Select::make('type_id')
                    ->searchable()
                    ->preload()
                    ->relationship('type', 'name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('id', 'desc'))
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('brand_id')
                    ->searchable()
                    ->preload()
                    ->relationship('brand', 'name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('id', 'desc'))
                    ->native(false)
                    ->required(),
                Forms\Components\FileUpload::make('thumbnail_photos')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->disk('public') // Specifies the 'public' disk
                    ->directory('assets/item') // Directory where files will be stored
                    ->label('Upload Thumbnail')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('photos')
                    ->disk('public') // Specifies the 'public' disk
                    ->directory('assets/item') // Directory where files will be stored
                    ->multiple()
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->label('Upload Image')
                    ->image()
                    ->required(),
                Forms\Components\Textarea::make('features')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->label('Harga Sewa Perhari')
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('star')
                    ->numeric(),
                Forms\Components\TextInput::make('review')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('thumbnail_photos'),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('star')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('review')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListItems::route('/'),
            // 'create' => Pages\CreateItem::route('/create'),
            // 'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
