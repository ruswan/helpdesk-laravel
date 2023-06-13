<?php

return [
    'includes' => [
        // App\Filament\Resources\Blog\AuthorResource::class,
    ],
    'excludes' => [
        Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource::class,
        Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource::class,
    ],
    'should_convert_count' => true,
    'enable_convert_tooltip' => true,
];
