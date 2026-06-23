{{-- resources/views/admin/reports/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Laporan & Analitik')

@push('styles')
<style>
    .page-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a3c5e;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-card.blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card.green {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .stat-card.orange {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-card.red {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .stat-card .label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
    }

    .stat-card .value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }

    .chart-container {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .chart-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a3c5e;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-title i {
        font-size: 1.25rem;
    }

    .chart-wrapper {
        position: relative;
        height: 300px;
        margin-bottom: 1rem;
    }

    .table-section {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .table-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a3c5e;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .custom-table thead {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .custom-table thead th {
        padding: 0.75rem 1rem;
        font-weight: 600;
        color: #1a3c5e;
        text-align: left;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .custom-table tbody td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .custom-table tbody tr:hover {
        background-color: #f8f9ff;
    }

    .badge-positive {
        background-color: #d4edda;
        color: #155724;
        padding: 0.35rem 0.65rem;
        border-radius: 0.25rem;
        font-weight: 600;
    }

    .badge-active {
        background-color: #d4edda;
        color: #155724;
        padding: 0.35rem 0.65rem;
        border-radius: 0.25rem;
        font-weight: 600;
    }

    .badge-expired {
        background-color: #f8d7da;
        color: #721c24;
        padding: 0.35rem 0.65rem;
        border-radius: 0.25rem;
        font-weight: 600;
    }

    .rating-stars {
        color: #ffc107;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-2 {
            grid-template-columns: 1fr;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

<div class="container-fluid py-4">
    <!-- ── Page Header ────────────────────────────────────────────── -->
    <div class="page-header">
        <h1>
            <i class="bi bi-graph-up"></i>
            Laporan & Analitik
        </h1>
    </div>

    <!-- ── Statistics Cards ───────────────────────────────────────── -->
    <div class="stats-grid">
        <!-- Positive Reviews -->
        <div class="stat-card green">
            <div class="label"><i class="bi bi-hand-thumbs-up"></i> Positif (4-5)</div>
            <div class="value">{{ $sentiment['positive'] }}</div>
        </div>

        <!-- Neutral Reviews -->
        <div class="stat-card blue">
            <div class="label"><i class="bi bi-minus-circle"></i> Netral (3)</div>
            <div class="value">{{ $sentiment['neutral'] }}</div>
        </div>

        <!-- Negative Reviews -->
        <div class="stat-card orange">
            <div class="label"><i class="bi bi-hand-thumbs-down"></i> Negatif (1-2)</div>
            <div class="value">{{ $sentiment['negative'] }}</div>
        </div>

        <!-- Active Coupons -->
        <div class="stat-card green">
            <div class="label"><i class="bi bi-tag"></i> Kupon Aktif</div>
            <div class="value">{{ $couponStats['active'] }}</div>
        </div>

        <!-- Expired Coupons -->
        <div class="stat-card red">
            <div class="label"><i class="bi bi-x-circle"></i> Kupon Kadaluarsa</div>
            <div class="value">{{ $couponStats['expired'] }}</div>
        </div>

        <!-- Total Coupon Usage -->
        <div class="stat-card blue">
            <div class="label"><i class="bi bi-graph-up"></i> Total Penggunaan</div>
            <div class="value">{{ number_format($couponStats['totalUsage']) }}</div>
        </div>
    </div>

    <!-- ── Charts Row ─────────────────────────────────────────────── -->
    <div class="grid-2">
        <!-- Sentiment Analysis Pie Chart -->
        <div class="chart-container">
            <div class="chart-title">
                <i class="bi bi-pie-chart"></i>
                Analisis Sentimen Rating
            </div>
            <div class="chart-wrapper">
                <canvas id="sentimentChart"></canvas>
            </div>
            <div style="font-size: 0.875rem; color: #6c757d;">
                <p><strong>Total Reviews:</strong> {{ $sentiment['positive'] + $sentiment['neutral'] + $sentiment['negative'] }}</p>
            </div>
        </div>

        <!-- Coupon Status Bar Chart -->
        <div class="chart-container">
            <div class="chart-title">
                <i class="bi bi-bar-chart"></i>
                Status Kupon
            </div>
            <div class="chart-wrapper">
                <canvas id="couponStatusChart"></canvas>
            </div>
            <div style="font-size: 0.875rem; color: #6c757d;">
                <p><strong>Total Coupons:</strong> {{ $couponStats['active'] + $couponStats['expired'] }}</p>
            </div>
        </div>
    </div>

    <!-- ── Rating Distribution Bar Chart ──────────────────────────── -->
    <div class="chart-container">
        <div class="chart-title">
            <i class="bi bi-bar-chart-line"></i>
            Persentase Sentimen
        </div>
        <div class="chart-wrapper" style="height: 250px;">
            <canvas id="sentimentPercentageChart"></canvas>
        </div>
    </div>

    <!-- ── Coupon Statistics Info ────────────────────────────────── -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="chart-container">
            <div class="chart-title">
                <i class="bi bi-info-circle"></i>
                Statistik Kupon
            </div>
            <table class="custom-table">
                <tbody>
                    <tr>
                        <td><strong>Kupon Aktif</strong></td>
                        <td style="text-align: right;"><span class="badge-active">{{ $couponStats['active'] }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Kupon Kadaluarsa</strong></td>
                        <td style="text-align: right;"><span class="badge-expired">{{ $couponStats['expired'] }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Total Penggunaan</strong></td>
                        <td style="text-align: right; color: #0d6efd; font-weight: 600;">{{ number_format($couponStats['totalUsage']) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Rata-rata Penggunaan</strong></td>
                        <td style="text-align: right; color: #0d6efd; font-weight: 600;">{{ number_format($couponStats['avgUsagePerCoupon'], 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kupon Mencapai Limit</strong></td>
                        <td style="text-align: right; color: #dc3545; font-weight: 600;">{{ $couponStats['atLimitCoupons'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Coupon Usage Efficiency -->
        <div class="chart-container">
            <div class="chart-title">
                <i class="bi bi-percent"></i>
                Efisiensi Penggunaan
            </div>
            <div style="padding: 1rem 0;">
                <div style="margin-bottom: 1rem;">
                    <p style="margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600;">Tingkat Penggunaan Rata-rata</p>
                    <div class="progress" style="height: 8px;">
                        @php
                            $usagePercentage = $couponStats['active'] > 0
                                ? min(($couponStats['totalUsage'] / ($couponStats['active'] * 100)) * 100, 100)
                                : 0;
                        @endphp
                        <div class="progress-bar bg-success" style="width: {{ $usagePercentage }}%"></div>
                    </div>
                    <p style="font-size: 0.75rem; color: #6c757d; margin-top: 0.25rem;">{{ number_format($usagePercentage, 1) }}%</p>
                </div>

                <div>
                    <p style="margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600;">Kupon Mencapai Batas</p>
                    @php
                        $limitPercentage = $couponStats['active'] > 0
                            ? ($couponStats['atLimitCoupons'] / $couponStats['active']) * 100
                            : 0;
                    @endphp
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ $limitPercentage }}%"></div>
                    </div>
                    <p style="font-size: 0.75rem; color: #6c757d; margin-top: 0.25rem;">{{ number_format($limitPercentage, 1) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Top Rated Products ─────────────────────────────────────── -->
    <div class="table-section">
        <div class="table-title">
            <i class="bi bi-star"></i>
            Produk Tertinggi Rating
        </div>
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah Review</th>
                        <th>Rating Rata-rata</th>
                        <th>Review Terbaru</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topRatedProducts as $product)
                        <tr>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->review_count }}</td>
                            <td>
                                <span class="rating-stars">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < floor($product->avg_rating))
                                            ★
                                        @elseif($i < floor($product->avg_rating) + 0.5)
                                            ½
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <span style="color: #1a3c5e; font-weight: 600;">{{ number_format($product->avg_rating, 1) }}</span>
                            </td>
                            <td style="font-size: 0.8rem; color: #6c757d;">{{ \Carbon\Carbon::parse($product->latest_review)->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #6c757d;">Belum ada data review</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Top Reviewers ──────────────────────────────────────────── -->
    <div class="table-section">
        <div class="table-title">
            <i class="bi bi-person-check"></i>
            Reviewer Paling Aktif
        </div>
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah Review</th>
                        <th>Rating Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topReviewers as $reviewer)
                        <tr>
                            <td><strong>{{ $reviewer->name }}</strong></td>
                            <td><span style="background: #e7f1ff; padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-weight: 600; color: #0d6efd;">{{ $reviewer->review_count }}</span></td>
                            <td>
                                <span class="rating-stars">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < floor($reviewer->avg_rating))
                                            ★
                                        @elseif($i < floor($reviewer->avg_rating) + 0.5)
                                            ½
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <span style="color: #1a3c5e; font-weight: 600;">{{ number_format($reviewer->avg_rating, 1) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #6c757d;">Belum ada data reviewer</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Most Used Coupons ──────────────────────────────────────── -->
    <div class="table-section">
        <div class="table-title">
            <i class="bi bi-tag-fill"></i>
            Kupon Paling Banyak Digunakan
        </div>
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Kode Kupon</th>
                        <th>Tipe Diskon</th>
                        <th>Nilai Diskon</th>
                        <th>Penggunaan</th>
                        <th>Limit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($couponTrend as $coupon)
                        <tr>
                            <td><strong style="color: #0d6efd;">{{ $coupon->code }}</strong></td>
                            <td>
                                @if($coupon->discount_type === 'percent')
                                    <span style="background: #e7f1ff; padding: 0.25rem 0.5rem; border-radius: 0.25rem; color: #0d6efd; font-weight: 600;">%</span>
                                @else
                                    <span style="background: #f8d7da; padding: 0.25rem 0.5rem; border-radius: 0.25rem; color: #721c24; font-weight: 600;">Rp</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->discount_type === 'percent')
                                    {{ $coupon->discount_value }}%
                                @else
                                    Rp {{ number_format($coupon->discount_value) }}
                                @endif
                            </td>
                            <td><strong>{{ $coupon->used_count }}</strong></td>
                            <td>
                                @if($coupon->usage_limit)
                                    {{ $coupon->usage_limit }}
                                @else
                                    <span style="color: #6c757d;">Unlimited</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->is_active)
                                    <span class="badge-active">Aktif</span>
                                @else
                                    <span class="badge-expired">Non-aktif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #6c757d;">Belum ada data kupon</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
    // Sentiment Analysis Pie Chart
    const sentimentCtx = document.getElementById('sentimentChart').getContext('2d');
    new Chart(sentimentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Positif (4-5)', 'Netral (3)', 'Negatif (1-2)'],
            datasets: [{
                data: [{{ $sentiment['positive'] }}, {{ $sentiment['neutral'] }}, {{ $sentiment['negative'] }}],
                backgroundColor: ['#38ef7d', '#667eea', '#f5576c'],
                borderColor: ['#11998e', '#667eea', '#fa709a'],
                borderWidth: 2,
                hoverBorderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12, weight: '600' },
                        padding: 15,
                        usePointStyle: true,
                    }
                }
            }
        }
    });

    // Coupon Status Bar Chart
    const couponStatusCtx = document.getElementById('couponStatusChart').getContext('2d');
    new Chart(couponStatusCtx, {
        type: 'bar',
        data: {
            labels: ['Aktif', 'Kadaluarsa'],
            datasets: [{
                label: 'Jumlah Kupon',
                data: [{{ $couponStats['active'] }}, {{ $couponStats['expired'] }}],
                backgroundColor: ['#38ef7d', '#f5576c'],
                borderColor: ['#11998e', '#fa709a'],
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: ['#11998e', '#fa709a'],
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: { size: 12, weight: '600' },
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Sentiment Percentage Bar Chart
    @php
        $totalReviews = $sentiment['positive'] + $sentiment['neutral'] + $sentiment['negative'];
        $positivePercent = $totalReviews > 0 ? ($sentiment['positive'] / $totalReviews) * 100 : 0;
        $neutralPercent = $totalReviews > 0 ? ($sentiment['neutral'] / $totalReviews) * 100 : 0;
        $negativePercent = $totalReviews > 0 ? ($sentiment['negative'] / $totalReviews) * 100 : 0;
    @endphp

    const sentimentPercentCtx = document.getElementById('sentimentPercentageChart').getContext('2d');
    new Chart(sentimentPercentCtx, {
        type: 'bar',
        data: {
            labels: ['Positif (4-5)', 'Netral (3)', 'Negatif (1-2)'],
            datasets: [{
                label: 'Persentase (%)',
                data: [{{ $positivePercent }}, {{ $neutralPercent }}, {{ $negativePercent }}],
                backgroundColor: ['#38ef7d', '#667eea', '#f5576c'],
                borderColor: ['#11998e', '#667eea', '#fa709a'],
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            indexAxis: 'x',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: { size: 12, weight: '600' },
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { callback: function(value) { return value + '%'; } }
                }
            }
        }
    });
</script>
@endpush
