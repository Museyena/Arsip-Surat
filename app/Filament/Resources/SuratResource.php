<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratResource\Pages;
use App\Filament\Resources\SuratResource\RelationManagers;
use App\Models\Surat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuratResource extends Resource
{
    protected static ?string $model = Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $pluralModelLabel = 'Data Surat';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('nomor_surat')
                ->required()
                ->maxLength(255)
                ->label('Nomor Surat'),
            Forms\Components\Select::make('kategori_id')
                ->relationship('kategori', 'nama_kategori')
                ->required()
                ->label('Kategori Surat'),
            Forms\Components\TextInput::make('judul')
                ->required()
                ->maxLength(255)
                ->label('Judul Surat'),
            Forms\Components\FileUpload::make('file_pdf')
                ->required()
                ->acceptedFileTypes(['application/pdf'])
                ->directory('surat')
                ->label('File PDF'),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diupload Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
        Tables\Filters\SelectFilter::make('kategori')
            ->relationship('kategori', 'nama_kategori')
            ->label('Filter Kategori'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Lihat')
                    ->color('info') 
                    ->icon('heroicon-o-eye') 
                    ->modalHeading(fn ($record) => $record->judul)
                    ->modalContent(fn ($record) => view('filament.resources.surat-resource.view-modal', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
                Tables\Actions\Action::make('Unduh')
                    ->url(fn ($record) => asset('storage/' . $record->file_pdf))
                    ->openUrlInNewTab()
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray'),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSurats::route('/'),
            'create' => Pages\CreateSurat::route('/create'),
            'edit' => Pages\EditSurat::route('/{record}/edit'),
        ];
    }
}