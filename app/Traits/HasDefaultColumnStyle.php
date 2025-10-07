<?php

namespace App\Traits;

use Filament\Tables\Columns\Column;

trait HasDefaultColumnStyle
{
    /**
     * Apply default style for list/index table columns.
     */
    protected static function applyListColumnStyle(Column $column): Column
    {
        return $column
            ->size('sm')
            ->searchable()
            ->disableClick()
            ->toggleable(isToggledHiddenByDefault: false); // visible by default
    }

    /**
     * Apply style for view/detail table columns.
     */
    protected static function applyViewColumnStyle(Column $column): Column
    {
        return $column
            ->size('md')
            ->disableClick(); // no search or toggle needed
    }

    /**
     * Apply style for compact/minimal table columns.
     */
    protected static function applyCompactColumnStyle(Column $column): Column
    {
        return $column
            ->size('xs')
            ->disableClick()
            ->toggleable(isToggledHiddenByDefault: true); // hidden by default
    }

    /**
     * Apply style for disabled columns (e.g., for internal use).
     */
    protected static function applyDisabledColumnStyle(Column $column): Column
    {
        return $column
            ->size('sm')
            ->disableClick()
            ->toggleable(isToggledHiddenByDefault: true)
            ->searchable(false); // explicitly not searchable
    }
}
