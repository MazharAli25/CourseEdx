@extends('layouts.CourseBuilder')

@section('css')
    <style>
        .pricing-card {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .pricing-card:hover {
            border-color: #6f42c1;
            box-shadow: 0 0.5rem 1rem rgba(111, 66, 193, 0.15);
        }

        .price-input-wrapper {
            position: relative;
        }

        .price-currency {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 600;
            color: #6c757d;
        }

        .price-input {
            padding-left: 40px;
            font-size: 1.5rem;
            font-weight: 600;
            height: 60px;
        }

        .free-badge {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
        }

        .discount-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .currency-select {
            max-width: 200px;
        }
    </style>
@endsection

@section('title', 'Course Pricing')
@section('page-title', 'Set Course Price')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                {{-- <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('courses.basic', $course->id) }}">Basic Info</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('courses.curriculum', $course->id) }}">Curriculum</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('courses.requirements', $course->id) }}">Requirements</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pricing</li>
                        </ol>
                    </nav>
                </div> --}}

                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-tag mr-2"></i>Course Pricing
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pricing.store', $course->id) }}" method="POST" id="pricingForm">
                            @csrf

                            <!-- Pricing Type Selection -->
                            {{-- <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pricing_type" 
                                               id="freeCourse" value="free" checked>
                                        <label class="form-check-label" for="freeCourse">
                                            <h5 class="font-weight-bold">Free Course</h5>
                                            <p class="text-muted mb-0">Offer this course for free to all students</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pricing_type" 
                                               id="paidCourse" value="paid">
                                        <label class="form-check-label" for="paidCourse">
                                            <h5 class="font-weight-bold">Paid Course</h5>
                                            <p class="text-muted mb-0">Set a price for students to enroll</p>
                                        </label>
                                    </div>
                                </div>
                            </div> 
                            
                            <hr class="my-4"> --}}

                            <!-- Price Input Section (Hidden by default) -->
                            <div id="priceInputSection">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Currency Selection -->
                                        <div class="form-group">
                                            <label for="currency" class="font-weight-bold">Currency</label>
                                            <select name="currency" id="currency" class="form-control currency-select">
                                                <option value="USD"
                                                    {{ isset($price->currency) && $price->currency === 'USD' ? 'selected' : '' }}>
                                                    USD - US Dollar ($)</option>
                                                <option value="PKR"
                                                    {{ isset($price->currency) && $price->currency === 'PKR' ? 'selected' : '' }}>
                                                    PKR - Pakistani Rupee (PKR)</option>
                                                <option value="EUR"
                                                    {{ isset($price->currency) && $price->currency === 'EUR' ? 'selected' : '' }}>
                                                    EUR - Euro (€)</option>
                                                <option value="GBP"
                                                    {{ isset($price->currency) && $price->currency === 'GBP' ? 'selected' : '' }}>
                                                    GBP - British Pound (£)</option>
                                                <option value="INR"
                                                    {{ isset($price->currency) && $price->currency === 'INR' ? 'selected' : '' }}>
                                                    INR - Indian Rupee (₹)</option>
                                                <option value="CAD"
                                                    {{ isset($price->currency) && $price->currency === 'CAD' ? 'selected' : '' }}>
                                                    CAD - Canadian Dollar (C$)</option>
                                                <option value="AUD"
                                                    {{ isset($price->currency) && $price->currency === 'AUD' ? 'selected' : '' }}>
                                                    AUD - Australian Dollar (A$)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Currency Symbol -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Currency Symbol</label>
                                            <input type="text" name="currencySymbol" id="currency_symbol"
                                                class="form-control" value="{{ $price->currencySymbol ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Input -->
                                <div class="form-group">
                                    <label for="price" class="font-weight-bold">Course Price</label>
                                    <div class="price-input-wrapper">
                                        <input type="number" name="price" id="price" class="form-control price-input"
                                            value="{{ isset($price->price) ? $price->price : '' }}" min="0"
                                            step="0.01" placeholder="0.00" required>
                                    </div>
                                    <small class="form-text text-muted">
                                        Enter the price students will pay to enroll in your course
                                    </small>
                                </div>

                                <!-- Discount Section -->
                                {{-- <div class="discount-section mt-4">
                                    <h5 class="font-weight-bold mb-3">Discount Settings (Optional)</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount_price">Discount Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="discountCurrencySymbol">$</span>
                                                    </div>
                                                    <input type="number" name="discount_price" id="discount_price" 
                                                           class="form-control" min="0" step="0.01" 
                                                           placeholder="0.00">
                                                </div>
                                                <small class="form-text text-muted">
                                                    Special price for limited time
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount_percentage">Discount Percentage</label>
                                                <div class="input-group">
                                                    <input type="number" name="discount_percentage" 
                                                           id="discount_percentage" class="form-control" 
                                                           min="0" max="100" step="0.1" placeholder="0">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">
                                                    Or set percentage discount (0-100%)
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Discount Dates -->
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount_start">Discount Start Date</label>
                                                <input type="date" name="discount_start" id="discount_start" 
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount_end">Discount End Date</label>
                                                <input type="date" name="discount_end" id="discount_end" 
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>--}
                                    
                                    <!-- Preview Price -->
                                    <div class="alert alert-info mt-3" id="pricePreview">
                                        <strong>Price Preview:</strong>
                                        <div class="mt-2">
                                            <span class="strike-price" id="originalPriceDisplay">$0.00</span>
                                            <span class="h5 ml-2 text-success" id="finalPriceDisplay">$0.00</span>
                                            <span class="badge badge-success ml-2 d-none" id="discountBadge">0% OFF</span>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                            <!-- Free Course Message -->
                            {{-- <div id="freeCourseMessage" class="text-center py-4">
                                <div class="alert alert-success">
                                    <i class="fas fa-gift fa-2x mb-3"></i>
                                    <h4>Your course will be free!</h4>
                                    <p class="mb-0">Students can enroll in your course without any payment.</p>
                                </div>
                            </div> --}}

                            <!-- Navigation Buttons -->
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <a href="{{ route('faq.index', $course->id) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left mr-2"></i> Back to FAQs
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-lightbulb mr-2"></i>Pricing Tips</h5>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Research similar courses to set a competitive price</li>
                            <li>Consider offering a launch discount for the first month</li>
                            <li>Free courses can help build your student base and reviews</li>
                            <li>Update your pricing regularly based on course updates and demand</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Currency symbols mapping
            const currencySymbols = {
                'USD': '$',
                'PKR': 'PKR',
                'EUR': '€',
                'GBP': '£',
                'INR': '₹',
                'CAD': 'C$',
                'AUD': 'A$'
            };

            // Toggle pricing type
            // $('input[name="pricing_type"]').change(function() {
            //     if ($(this).val() === 'paid') {
            //         $('#priceInputSection').removeClass('d-none');
            //         $('#freeCourseMessage').addClass('d-none');
            //         $('#price').prop('required', true);
            //     } else {
            //         $('#priceInputSection').addClass('d-none');
            //         $('#freeCourseMessage').removeClass('d-none');
            //         $('#price').prop('required', false);
            //     }
            // });

            // Currency change handler
            $('#currency').change(function() {
                const symbol = currencySymbols[$(this).val()] || '$';
                $('#currency_symbol').val(symbol);
                $('#currencySymbolDisplay').text(symbol);
                $('#discountCurrencySymbol').text(symbol);
                updatePricePreview();
            });

            // Price calculation and preview
            // function updatePricePreview() {
            //     const price = parseFloat($('#price').val()) || 0;
            //     const discountPrice = parseFloat($('#discount_price').val());
            //     const discountPercent = parseFloat($('#discount_percentage').val());
            //     const symbol = $('#currency_symbol').val();

            //     let finalPrice = price;
            //     let discountText = '';

            //     if (discountPrice && discountPrice > 0 && discountPrice < price) {
            //         finalPrice = discountPrice;
            //         const discountAmount = price - discountPrice;
            //         const discountPercentage = Math.round((discountAmount / price) * 100);
            //         discountText = discountPercentage + '% OFF';
            //     } else if (discountPercent && discountPercent > 0 && discountPercent <= 100) {
            //         finalPrice = price - (price * discountPercent / 100);
            //         discountText = discountPercent + '% OFF';
            //     }

            //     // Update displays
            //     $('#originalPriceDisplay').text(symbol + price.toFixed(2));
            //     $('#finalPriceDisplay').text(symbol + finalPrice.toFixed(2));

            //     if (discountText && finalPrice < price) {
            //         $('#discountBadge').text(discountText).removeClass('d-none');
            //         $('#originalPriceDisplay').addClass('strike-price');
            //     } else {
            //         $('#discountBadge').addClass('d-none');
            //         $('#originalPriceDisplay').removeClass('strike-price');
            //     }
            // }

            // Bind price update events
            $('#price, #discount_price, #discount_percentage').on('input', updatePricePreview);

            // Initialize
            updatePricePreview();
        });
    </script>
@endpush
