$(document).ready(function() {
    // Initialize Select2
    $('.form-control-select').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // File Upload Preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                $('#file-preview').html(`
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-2"></i>
                        File berhasil diunggah: ${input.files[0].name}
                    </div>
                `);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#bukti_kasus").change(function() {
        readURL(this);
    });

    // Form Steps
    let currentStep = 1;
    const totalSteps = 3;

    function updateSteps() {
        $('.form-step').hide();
        $(`#step-${currentStep}`).show();
        
        // Update progress
        $('.step').removeClass('active');
        for(let i = 1; i <= currentStep; i++) {
            $(`.step:nth-child(${i})`).addClass('active');
        }

        // Update buttons
        if(currentStep === 1) {
            $('#prevBtn').hide();
        } else {
            $('#prevBtn').show();
        }

        if(currentStep === totalSteps) {
            $('#nextBtn').hide();
            $('#submitBtn').show();
        } else {
            $('#nextBtn').show();
            $('#submitBtn').hide();
        }
    }

    $('#nextBtn').click(function() {
        if(validateStep(currentStep)) {
            currentStep++;
            updateSteps();
        }
    });

    $('#prevBtn').click(function() {
        currentStep--;
        updateSteps();
    });

    // Form Validation
    function validateStep(step) {
        let isValid = true;
        const requiredFields = $(`#step-${step} [required]`);

        requiredFields.each(function() {
            if(!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
                
                // Show error message
                if(!$(this).next('.invalid-feedback').length) {
                    $(this).after(`
                        <div class="invalid-feedback">
                            Field ini wajib diisi
                        </div>
                    `);
                }
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        return isValid;
    }

    // Remove invalid state on input
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });

    // Form Submit Loading State
    $('form').on('submit', function() {
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true);
        btn.html(`
            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
            Mengirim...
        `);
    });
    

});
