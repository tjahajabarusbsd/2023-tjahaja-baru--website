<?php

return [
    'tiers' => [
        [
            'name' => 'Basic',
            'min_points' => 0,
            'max_points' => 999,
            'color' => '#B0B0B0',
            'voucher_service' => 2,
        ],
        [
            'name' => 'Silver',
            'min_points' => 1000,
            'max_points' => 49999,
            'color' => '#4D7CFE',
            'voucher_service' => 4,
        ],
        [
            'name' => 'Gold',
            'min_points' => 50000,
            'max_points' => 99999,
            'color' => '#FFD700',
            'voucher_service' => 6,
        ],
        [
            'name' => 'Platinum',
            'min_points' => 100000,
            'max_points' => null,
            'color' => '#E5E4E2',
            'voucher_service' => 10,
        ],
    ],
];
