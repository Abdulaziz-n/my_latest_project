<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionsListResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            "gifts" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "roles" => [
                "edit" => false,
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "users" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "guides" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "levels" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "offers" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "prizes" => [
                "view" => false,
                "update" => false
            ],
            "socials" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "policies" => [
                "view" => false,
                "update" => false
            ],
            "categories" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "levels_gifts" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "levels_score" => [
                "view" => false,
                "create" => false,
                "delete" => false,
                "update" => false
            ],
            "activate_pack" => [
                "activate" => false
            ],
            "winners" => [
                "view" => false
            ],

            'statistics' => [
                'view' => false
            ],

            'statistics_page' => [
                'view' => false
            ],

            "charges" => [
                'view' => false
            ],
            'profits' => [
                'view' => false,
            ],

            'subscribers' => [
                'view' => false,
            ],

            'subscribers_activities' => [
                'view' => false
            ]

        ];
    }
}
