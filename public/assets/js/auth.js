// Animasi loading pada tombol login
$('form.user').on('submit', function() {
    const btn = $(this).find('button[type="submit"]');
    btn.html('<i class="fas fa-circle-notch fa-spin"></i> Loading...');
    btn.prop('disabled', true);
});

// Animasi show/hide password
$(document).ready(function() {
    const togglePassword = `
        <span class="password-toggle" style="position: absolute; right: 1rem; top: 1rem; cursor: pointer;">
            <i class="fas fa-eye"></i>
        </span>
    `;
    
    $('.form-group:has(input[type="password"])').css('position', 'relative').append(togglePassword);
    
    $('.password-toggle').click(function() {
        const input = $(this).siblings('input');
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});

// Animasi alert
$('.alert').hide().fadeIn(500);

// Auto hide alert after 5 seconds
setTimeout(function() {
    $('.alert').fadeOut(500);
}, 5000);

// Multi-step form handling
$(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 3;

    function updateSteps() {
        $('.step-content').addClass('d-none');
        $(`#step${currentStep}`).removeClass('d-none');
        
        // Update progress steps
        $('.step').removeClass('active');
        for(let i = 1; i <= currentStep; i++) {
            $(`.step:nth-child(${i})`).addClass('active');
        }

        // Update buttons
        $('#prevBtn').toggle(currentStep > 1);
        $('#nextBtn').toggle(currentStep < totalSteps);
        $('#submitBtn').toggle(currentStep === totalSteps);
    }

    $('#nextBtn').click(function() {
        if(currentStep < totalSteps) {
            currentStep++;
            updateSteps();
        }
    });

    $('#prevBtn').click(function() {
        if(currentStep > 1) {
            currentStep--;
            updateSteps();
        }
    });

    // Role card selection
    $('.role-card').click(function() {
        $('.role-card').removeClass('selected');
        $(this).addClass('selected');
        const role = $(this).data('role');
        $('#selected_role').val(role);
        
        if(role === 'kemahasiswaan') {
            $('#fakultas-container').removeClass('d-none');
        } else {
            $('#fakultas-container').addClass('d-none');
        }
    });

    // Password strength meter
    $('input[name="password"]').on('input', function() {
        const password = $(this).val();
        let strength = 0;
        
        if(password.length >= 8) strength++;
        if(password.match(/[A-Z]/)) strength++;
        if(password.match(/[0-9]/)) strength++;
        if(password.match(/[^A-Za-z0-9]/)) strength++;

        const $progress = $('.password-strength .progress-bar');
        const $text = $('.password-strength span');

        switch(strength) {
            case 0:
                $progress.css('width', '0%').removeClass().addClass('progress-bar bg-danger');
                $text.text('Lemah');
                break;
            case 2:
                $progress.css('width', '50%').removeClass().addClass('progress-bar bg-warning');
                $text.text('Sedang');
                break;
            case 3:
                $progress.css('width', '75%').removeClass().addClass('progress-bar bg-info');
                $text.text('Kuat');
                break;
            case 4:
                $progress.css('width', '100%').removeClass().addClass('progress-bar bg-success');
                $text.text('Sangat Kuat');
                break;
        }
    });
});