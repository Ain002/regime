<?php

/**
 * Price Helper Functions
 * Provides utilities for calculating regime prices with Gold option
 */

/**
 * Calculate final price based on base price, duration and Gold status
 * @param float $basePrice - Base price per week
 * @param int $duration - Duration in weeks
 * @param bool $hasGold - Whether user has Gold subscription
 * @return array ['original' => float, 'final' => float, 'discount' => float, 'discount_percent' => float]
 */
function calculateRegimePrice($basePrice, $duration, $hasGold = false)
{
    $originalPrice = $basePrice * $duration;
    $discount = 0;
    $discountPercent = 0;

    if ($hasGold) {
        $discount = $originalPrice * 0.15; // 15% reduction
        $discountPercent = 15;
    }

    return [
        'original' => round($originalPrice, 2),
        'final' => round($originalPrice - $discount, 2),
        'discount' => round($discount, 2),
        'discount_percent' => $discountPercent,
        'has_gold' => $hasGold
    ];
}

/**
 * Format price for display
 * @param float $price - Price to format
 * @param string $currency - Currency symbol (default €)
 * @return string Formatted price string
 */
function formatPrice($price, $currency = '€')
{
    return number_format($price, 2, ',', ' ') . ' ' . $currency;
}

/**
 * Get price breakdown for display
 * @param float $basePrice - Base price
 * @param int $duration - Duration in weeks
 * @param bool $hasGold - Gold option status
 * @return string HTML price display
 */
function getPriceDisplay($basePrice, $duration, $hasGold = false)
{
    $prices = calculateRegimePrice($basePrice, $duration, $hasGold);
    
    $html = '<div class="price-display">';
    $html .= '<span class="price-original">' . formatPrice($prices['original']) . '</span>';
    
    if ($hasGold) {
        $html .= ' <span class="badge bg-success ms-2">-' . $prices['discount_percent'] . '%</span>';
        $html .= '<div class="price-final">' . formatPrice($prices['final']) . '</div>';
    } else {
        $html .= '<div class="price-final">' . formatPrice($prices['final']) . '</div>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Calculate composition percentages validation
 * @param float $viande - Meat percentage
 * @param float $poisson - Fish percentage
 * @param float $volaille - Poultry percentage
 * @return array ['valid' => bool, 'total' => float, 'error' => string|null]
 */
function validateComposition($viande, $poisson, $volaille)
{
    $total = $viande + $poisson + $volaille;
    $tolerance = 0.01; // Allow small rounding differences
    
    if (abs($total - 100) < $tolerance) {
        return [
            'valid' => true,
            'total' => $total,
            'error' => null
        ];
    }
    
    return [
        'valid' => false,
        'total' => $total,
        'error' => $total < 100 
            ? "Manquant: " . (100 - $total) . "%" 
            : "Excédent: " . ($total - 100) . "%"
    ];
}

/**
 * Get composition chart data
 * @param float $viande - Meat percentage
 * @param float $poisson - Fish percentage
 * @param float $volaille - Poultry percentage
 * @return array Chart data for visualization
 */
function getCompositionChartData($viande, $poisson, $volaille)
{
    return [
        'labels' => ['Viande', 'Poisson', 'Volaille'],
        'data' => [
            round($viande, 2),
            round($poisson, 2),
            round($volaille, 2)
        ],
        'colors' => ['#dc3545', '#0dcaf0', '#ffc107'],
        'backgroundColors' => ['rgba(220, 53, 69, 0.5)', 'rgba(13, 202, 240, 0.5)', 'rgba(255, 193, 7, 0.5)']
    ];
}
