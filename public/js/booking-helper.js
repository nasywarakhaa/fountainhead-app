/**
 * Fountainhead Booking Helper Functions
 * All data communication is base64 encoded for security
 */

// Base64 Encode/Decode Functions
function encodeData(data) {
    return btoa(encodeURIComponent(JSON.stringify(data)));
}

function decodeData(encodedData) {
    try {
        return JSON.parse(decodeURIComponent(atob(encodedData)));
    } catch (e) {
        console.error('Decode error:', e);
        return null;
    }
}

// Check Coliving Room Availability
async function checkRoomAvailability(roomId, checkIn, checkOut) {
    try {
        const response = await fetch('/api/coliving/check-availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                room_id: roomId,
                check_in: checkIn,
                check_out: checkOut
            })
        });

        const result = await response.json();
        const decodedData = decodeData(result.data);

        console.log('Room Availability:', decodedData);
        return decodedData;
    } catch (error) {
        console.error('Error checking availability:', error);
        return null;
    }
}

// Check Cafe Event Availability
async function checkCafeAvailability(eventDate, startTime, endTime) {
    try {
        const response = await fetch('/api/cafe/check-availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                event_date: eventDate,
                start_time: startTime,
                end_time: endTime
            })
        });

        const result = await response.json();
        const decodedData = decodeData(result.data);

        console.log('Cafe Availability:', decodedData);
        return decodedData;
    } catch (error) {
        console.error('Error checking availability:', error);
        return null;
    }
}

// Calculate Cafe Event Price
async function calculateCafePrice(startTime, endTime, spaceType, guests, cateringRequired = false) {
    try {
        const response = await fetch('/api/cafe/calculate-price', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                start_time: startTime,
                end_time: endTime,
                space_type: spaceType,
                expected_guests: guests,
                catering_required: cateringRequired
            })
        });

        const result = await response.json();
        const decodedData = decodeData(result.data);

        console.log('Price Breakdown:', decodedData);
        return decodedData;
    } catch (error) {
        console.error('Error calculating price:', error);
        return null;
    }
}

// Format Rupiah
function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
}

// Format Date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Format Time
function formatTime(timeString) {
    return new Date('2000-01-01 ' + timeString).toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Calculate nights between two dates
function calculateNights(checkIn, checkOut) {
    const start = new Date(checkIn);
    const end = new Date(checkOut);
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays;
}

// Validate date range
function validateDateRange(checkIn, checkOut) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const startDate = new Date(checkIn);
    const endDate = new Date(checkOut);

    if (startDate < today) {
        return { valid: false, message: 'Check-in date cannot be in the past' };
    }

    if (endDate <= startDate) {
        return { valid: false, message: 'Check-out date must be after check-in date' };
    }

    return { valid: true, message: 'Valid date range' };
}

// Show loading state
function showLoading(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.innerHTML = '<div class="flex justify-center items-center py-8"><div class="w-8 h-8 border-4 border-orange-500 border-t-transparent rounded-full animate-spin"></div></div>';
    }
}

// Show success message
function showSuccess(message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            confirmButtonColor: '#F59E0B'
        });
    } else {
        alert(message);
    }
}

// Show error message
function showError(message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
            confirmButtonColor: '#F59E0B'
        });
    } else {
        alert(message);
    }
}

// Show info message
function showInfo(message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: message,
            confirmButtonColor: '#F59E0B'
        });
    } else {
        alert(message);
    }
}

// Debounce function for input events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Live availability checker for room booking form
function initRoomAvailabilityChecker() {
    const roomIdInput = document.getElementById('room_id');
    const checkInInput = document.getElementById('check_in_date');
    const checkOutInput = document.getElementById('check_out_date');
    const availabilityStatus = document.getElementById('availability_status');

    if (!roomIdInput || !checkInInput || !checkOutInput) return;

    const checkAvailability = debounce(async () => {
        const roomId = roomIdInput.value;
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;

        if (!roomId || !checkIn || !checkOut) return;

        const validation = validateDateRange(checkIn, checkOut);
        if (!validation.valid) {
            if (availabilityStatus) {
                availabilityStatus.innerHTML = `<div class="text-red-500 text-sm">${validation.message}</div>`;
            }
            return;
        }

        if (availabilityStatus) {
            availabilityStatus.innerHTML = '<div class="text-gray-500 text-sm">Checking availability...</div>';
        }

        const result = await checkRoomAvailability(roomId, checkIn, checkOut);

        if (result) {
            const nights = calculateNights(checkIn, checkOut);
            if (result.available) {
                if (availabilityStatus) {
                    availabilityStatus.innerHTML = `
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                            <i class="fas fa-check-circle mr-2"></i>
                            Available for ${nights} night(s)
                        </div>
                    `;
                }
            } else {
                if (availabilityStatus) {
                    availabilityStatus.innerHTML = `
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <i class="fas fa-times-circle mr-2"></i>
                            Not available for selected dates
                        </div>
                    `;
                }
            }
        }
    }, 500);

    checkInInput.addEventListener('change', checkAvailability);
    checkOutInput.addEventListener('change', checkAvailability);
}

// Live price calculator for cafe booking form
function initCafePriceCalculator() {
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const spaceTypeInput = document.getElementById('space_type');
    const guestsInput = document.getElementById('expected_guests');
    const cateringCheckbox = document.getElementById('catering_required');
    const priceDisplay = document.getElementById('price_display');

    if (!startTimeInput || !endTimeInput || !spaceTypeInput || !guestsInput) return;

    const calculatePrice = debounce(async () => {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        const spaceType = spaceTypeInput.value;
        const guests = guestsInput.value;
        const cateringRequired = cateringCheckbox ? cateringCheckbox.checked : false;

        if (!startTime || !endTime || !spaceType || !guests) return;

        if (priceDisplay) {
            priceDisplay.innerHTML = '<div class="text-gray-500 text-sm">Calculating price...</div>';
        }

        const result = await calculateCafePrice(startTime, endTime, spaceType, guests, cateringRequired);

        if (result && priceDisplay) {
            priceDisplay.innerHTML = `
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span>Base Rate (${result.duration_hours}h)</span>
                            <span>${formatRupiah(result.base_total)}</span>
                        </div>
                        ${result.space_extra > 0 ? `
                        <div class="flex justify-between text-sm">
                            <span>Space Extra</span>
                            <span>${formatRupiah(result.space_extra)}</span>
                        </div>
                        ` : ''}
                        ${result.catering_fee > 0 ? `
                        <div class="flex justify-between text-sm">
                            <span>Catering Fee</span>
                            <span>${formatRupiah(result.catering_fee)}</span>
                        </div>
                        ` : ''}
                        <div class="border-t border-orange-300 pt-2 mt-2">
                            <div class="flex justify-between font-bold">
                                <span>Total Amount</span>
                                <span class="text-orange-600">${formatRupiah(result.total_amount)}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 mt-1">
                                <span>Deposit (30%)</span>
                                <span>${formatRupiah(result.dp_amount)}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }, 500);

    startTimeInput.addEventListener('change', calculatePrice);
    endTimeInput.addEventListener('change', calculatePrice);
    spaceTypeInput.addEventListener('change', calculatePrice);
    guestsInput.addEventListener('change', calculatePrice);
    if (cateringCheckbox) cateringCheckbox.addEventListener('change', calculatePrice);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initRoomAvailabilityChecker();
    initCafePriceCalculator();
});

// Export functions for global use
window.BookingHelper = {
    encodeData,
    decodeData,
    checkRoomAvailability,
    checkCafeAvailability,
    calculateCafePrice,
    formatRupiah,
    formatDate,
    formatTime,
    calculateNights,
    validateDateRange,
    showLoading,
    showSuccess,
    showError,
    showInfo
};
