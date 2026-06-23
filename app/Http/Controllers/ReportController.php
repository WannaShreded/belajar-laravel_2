<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display sentiment analysis and coupon report
     */
    public function index(Request $request)
    {
        // ── 1. Sentiment Analysis (Rating Distribution) ────────────────────────
        $sentimentData = $this->getSentimentAnalysis();

        // ── 2. Coupon Statistics ──────────────────────────────────────────────
        $couponStats = $this->getCouponStatistics();

        // ── 3. Reviews by Product (Top rated) ─────────────────────────────────
        $topRatedProducts = $this->getTopRatedProducts();

        // ── 4. Reviews by User (Most active reviewers) ────────────────────────
        $topReviewers = $this->getTopReviewers();

        // ── 5. Rating Trend (over time) ───────────────────────────────────────
        $ratingTrend = $this->getRatingTrend();

        // ── 6. Coupon Usage Trend ─────────────────────────────────────────────
        $couponTrend = $this->getCouponUsageTrend();

        return view('admin.reports.index', [
            'sentiment' => $sentimentData,
            'couponStats' => $couponStats,
            'topRatedProducts' => $topRatedProducts,
            'topReviewers' => $topReviewers,
            'ratingTrend' => $ratingTrend,
            'couponTrend' => $couponTrend,
        ]);
    }

    /**
     * Get sentiment analysis data (Query Builder - NOT Eloquent)
     */
    private function getSentimentAnalysis(): array
    {
        $results = DB::table('reviews')
            ->select(
                DB::raw("
                    CASE
                        WHEN rating >= 4 THEN 'positive'
                        WHEN rating = 3 THEN 'neutral'
                        WHEN rating <= 2 THEN 'negative'
                    END as sentiment
                "),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('sentiment'))
            ->get();

        $data = [
            'positive' => 0,
            'neutral' => 0,
            'negative' => 0,
        ];

        foreach ($results as $row) {
            $data[$row->sentiment] = $row->count;
        }

        return $data;
    }

    /**
     * Get coupon statistics (Query Builder - NOT Eloquent)
     */
    private function getCouponStatistics(): array
    {
        // Active coupons
        $activeCoupons = DB::table('coupons')
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->count();

        // Expired coupons
        $expiredCoupons = DB::table('coupons')
            ->where(function ($query) {
                $query->where('is_active', false)
                    ->orWhere('expires_at', '<=', now());
            })
            ->count();

        // Total coupon usage
        $totalUsage = DB::table('coupons')
            ->sum('used_count');

        // Average usage per coupon
        $avgUsagePerCoupon = DB::table('coupons')
            ->avg('used_count');

        // Coupons at usage limit
        $atLimitCoupons = DB::table('coupons')
            ->whereNotNull('usage_limit')
            ->whereRaw('used_count >= usage_limit')
            ->count();

        return [
            'active' => $activeCoupons,
            'expired' => $expiredCoupons,
            'totalUsage' => (int) $totalUsage,
            'avgUsagePerCoupon' => round($avgUsagePerCoupon, 2),
            'atLimitCoupons' => $atLimitCoupons,
        ];
    }

    /**
     * Get top rated products (Query Builder)
     */
    private function getTopRatedProducts(): array
    {
        return DB::table('reviews')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('COUNT(*) as review_count'),
                DB::raw('AVG(reviews.rating) as avg_rating'),
                DB::raw('MAX(reviews.created_at) as latest_review')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('avg_rating')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get top reviewers (Query Builder)
     */
    private function getTopReviewers(): array
    {
        return DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COUNT(*) as review_count'),
                DB::raw('AVG(reviews.rating) as avg_rating')
            )
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('review_count')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get rating trend by date (Query Builder)
     */
    private function getRatingTrend(): array
    {
        $results = DB::table('reviews')
            ->select(
                DB::raw("DATE(created_at) as date"),
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(rating) as avg_rating')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return $results->reverse()->toArray();
    }

    /**
     * Get coupon usage trend (Query Builder)
     */
    private function getCouponUsageTrend(): array
    {
        $results = DB::table('coupons')
            ->select(
                'code',
                'discount_type',
                'discount_value',
                'usage_limit',
                'used_count',
                'is_active'
            )
            ->orderByDesc('used_count')
            ->limit(10)
            ->get();

        return $results->toArray();
    }
}
