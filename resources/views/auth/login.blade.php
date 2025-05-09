<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen p-6 bg-gradient-to-b from-indigo-500 to-purple-600">
    <div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Affiliate</h1>
            <p class="text-gray-600 mt-2" id="login-step-text">Log masuk dengan nombor telefon anda</p>
        </div>
        
        <div id="phone-step" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombor Telefon</label>
                <div class="flex">
                    <div class="flex items-center px-3 bg-gray-50 border border-r-0 border-gray-300 rounded-l-lg">
                        <span class="text-gray-500">+60</span>
                    </div>
                    <input 
                        type="tel" 
                        id="phone-number"
                        class="w-full px-4 py-3 rounded-r-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="1xxxxx xxxx"
                        maxlength="11"
                    />
                </div>
                <div class="text-sm text-red-500 mt-1 hidden" id="phone-error"></div>
            </div>
            
            <button
                type="button"
                id="request-otp-btn"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-300 cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                disabled
            >
                Hantar Kod Pengesahan
            </button>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum ada akaun? 
                    <span class="font-medium text-indigo-600 hover:text-indigo-500 ml-1 cursor-pointer">Daftar sekarang</span>
                </p>
            </div>
        </div>
        
        <div id="otp-step" class="space-y-6 hidden">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Kod Pengesahan</label>
                <div class="flex justify-between items-center">
                    @for($i = 0; $i < 6; $i++)
                        <input
                            type="text"
                            class="otp-input w-12 h-12 text-center text-xl font-medium border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            maxlength="1"
                            pattern="[0-9]"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            data-index="{{ $i }}"
                        />
                    @endfor
                </div>
                <div class="text-sm text-red-500 mt-2 hidden" id="otp-error"></div>
            </div>
            
            <div class="flex justify-between items-center">
                <button
                    type="button"
                    id="change-number-btn"
                    class="text-sm text-indigo-600 hover:text-indigo-500"
                >
                    Tukar Nombor Telefon
                </button>
                <button
                    type="button"
                    id="resend-otp-btn"
                    class="text-sm text-indigo-600 hover:text-indigo-500"
                >
                    Hantar Semula Kod
                </button>
            </div>
            
            <button
                type="button"
                id="verify-otp-btn"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-300 cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                disabled
            >
                Sahkan
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Phone number validation
        $('#phone-number').on('input', function() {
            const input = $(this).val().replace(/\D/g, '');
            $(this).val(input);
            
            if (input.length >= 10) {
                $('#request-otp-btn').removeClass('bg-indigo-300 cursor-not-allowed').addClass('bg-indigo-600 hover:bg-indigo-700');
                $('#request-otp-btn').prop('disabled', false);
            } else {
                $('#request-otp-btn').removeClass('bg-indigo-600 hover:bg-indigo-700').addClass('bg-indigo-300 cursor-not-allowed');
                $('#request-otp-btn').prop('disabled', true);
            }
        });
        
        // Request OTP
        $('#request-otp-btn').click(function() {
            const phoneNumber = $('#phone-number').val();
            
            if (phoneNumber.length < 10) {
                return;
            }
            
            $.ajax({
                url: '{{ route("login.requestOTP") }}',
                type: 'POST',
                data: {
                    phone_number: phoneNumber
                },
                beforeSend: function() {
                    $('#request-otp-btn').prop('disabled', true).text('Menghantar...');
                },
                success: function(response) {
                    // Switch to OTP step
                    $('#phone-step').addClass('hidden');
                    $('#otp-step').removeClass('hidden');
                    $('#login-step-text').text('Masukkan kod 6-digit yang dihantar ke nombor telefon anda');
                    
                    // Focus first OTP input
                    $('.otp-input[data-index="0"]').focus();
                    
                    // Debug: For demo purposes only, auto-fill OTP
                    if (response.debug_otp) {
                        const otpDigits = response.debug_otp.toString().split('');
                        otpDigits.forEach((digit, index) => {
                            $(`.otp-input[data-index="${index}"]`).val(digit);
                        });
                        validateOTP();
                    }
                },
                error: function(xhr) {
                    $('#phone-error').text(xhr.responseJSON.message || 'Error requesting OTP').removeClass('hidden');
                    $('#request-otp-btn').prop('disabled', false).text('Hantar Kod Pengesahan');
                }
            });
        });
        
        // OTP Input Handling
        $('.otp-input').on('input', function(e) {
            const value = $(this).val().replace(/\D/g, '');
            $(this).val(value);
            
            const index = parseInt($(this).data('index'));
            
            if (value && index < 5) {
                $(`.otp-input[data-index="${index + 1}"]`).focus();
            }
            
            validateOTP();
        });
        
        $('.otp-input').on('keydown', function(e) {
            const index = parseInt($(this).data('index'));
            
            // Handle backspace
            if (e.key === 'Backspace' && !$(this).val() && index > 0) {
                $(`.otp-input[data-index="${index - 1}"]`).focus();
            }
        });
        
        function validateOTP() {
            let otp = '';
            $('.otp-input').each(function() {
                otp += $(this).val();
            });
            
            if (otp.length === 6) {
                $('#verify-otp-btn').removeClass('bg-indigo-300 cursor-not-allowed').addClass('bg-indigo-600 hover:bg-indigo-700');
                $('#verify-otp-btn').prop('disabled', false);
            } else {
                $('#verify-otp-btn').removeClass('bg-indigo-600 hover:bg-indigo-700').addClass('bg-indigo-300 cursor-not-allowed');
                $('#verify-otp-btn').prop('disabled', true);
            }
        }
        
        // Change number button
        $('#change-number-btn').click(function() {
            $('#otp-step').addClass('hidden');
            $('#phone-step').removeClass('hidden');
            $('#login-step-text').text('Log masuk dengan nombor telefon anda');
            $('#otp-error').addClass('hidden');
            $('.otp-input').val('');
        });
        
        // Resend OTP button
        $('#resend-otp-btn').click(function() {
            const phoneNumber = $('#phone-number').val();
            
            $.ajax({
                url: '{{ route("login.requestOTP") }}',
                type: 'POST',
                data: {
                    phone_number: phoneNumber
                },
                beforeSend: function() {
                    $('#resend-otp-btn').prop('disabled', true);
                },
                success: function(response) {
                    // Reset OTP inputs
                    $('.otp-input').val('');
                    $('.otp-input[data-index="0"]').focus();
                    $('#otp-error').addClass('hidden');
                    
                    // Debug: For demo purposes only, auto-fill OTP
                    if (response.debug_otp) {
                        const otpDigits = response.debug_otp.toString().split('');
                        otpDigits.forEach((digit, index) => {
                            $(`.otp-input[data-index="${index}"]`).val(digit);
                        });
                        validateOTP();
                    }
                },
                error: function(xhr) {
                    $('#otp-error').text(xhr.responseJSON.message || 'Error resending OTP').removeClass('hidden');
                },
                complete: function() {
                    setTimeout(function() {
                        $('#resend-otp-btn').prop('disabled', false);
                    }, 30000); // Enable after 30 seconds
                }
            });
        });
        
        // Verify OTP
        $('#verify-otp-btn').click(function() {
            let otp = '';
            $('.otp-input').each(function() {
                otp += $(this).val();
            });
            
            if (otp.length !== 6) {
                return;
            }
            
            $.ajax({
                url: '{{ route("login.verifyOTP") }}',
                type: 'POST',
                data: {
                    otp: otp
                },
                beforeSend: function() {
                    $('#verify-otp-btn').prop('disabled', true).text('Mengesahkan...');
                },
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    $('#otp-error').text(xhr.responseJSON.message || 'Invalid OTP').removeClass('hidden');
                    $('#verify-otp-btn').prop('disabled', false).text('Sahkan');
                }
            });
        });
    });
</script>
@endpush