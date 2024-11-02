<?php

namespace MyTour\CoreBundle\Utils\Enum;

Enum RoleEnum: string {
    case ROLE_USER = 'Usuário';
    case ROLE_TRAVELER = 'Viajante';
    case ROLE_ORGANIZER = 'Organizador';
    case ROLE_ADMIN = 'Administrador';

    public static function getAllValueAndName(): array
    {
        $enums = [];
        foreach (static::cases() as $case) {
            $enums = array_merge([$case->value => $case->name], $enums);
        }

        return $enums;
    }

    public static function fromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null;
    }

    public static function fromNameBadge(string $name): string
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return "<span class='badge badge-inverse-" . self::getBadgeColor($case) . "'>$case->value</span>";
            }
        }
        return '';
    }

    private static function getBadgeColor(RoleEnum $roleEnum): ?string{
        return match ($roleEnum) {
            RoleEnum::ROLE_USER => "dark",
            RoleEnum::ROLE_TRAVELER => "primary",
            RoleEnum::ROLE_ORGANIZER => "info",
            RoleEnum::ROLE_ADMIN => "success",
        };
    }
}