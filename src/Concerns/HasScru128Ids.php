<?php

namespace GrantHolle\Scru128Laravel\Concerns;

use GrantHolle\Scru128\Scru128;
use GrantHolle\Scru128\Scru128Id;
use Illuminate\Database\Eloquent\Concerns\HasUniqueStringIds;
use InvalidArgumentException;

trait HasScru128Ids
{
    use HasUniqueStringIds {
        resolveRouteBindingQuery as private baseResolveRouteBindingQuery;
    }

    /**
     * Generate a new SCRU128 ID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) Scru128::generate();
    }

    /**
     * Retrieve the model for a bound value, normalizing case since SCRU128 IDs are case-insensitive.
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $column = $field ?: $this->getRouteKeyName();

        if (is_string($value) && in_array($column, $this->uniqueIds())) {
            $value = strtolower($value);
        }

        return $this->baseResolveRouteBindingQuery($query, $value, $field);
    }

    /**
     * Determine if the given key is a valid SCRU128 ID.
     */
    protected function isValidUniqueId($value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        try {
            Scru128Id::fromString($value);

            return true;
        } catch (InvalidArgumentException) {
            return false;
        }
    }
}
