$(document).ready(function() {
    // Animasi untuk progress bar
    $('.progress-bar').each(function() {
        const $bar = $(this);
        const width = $bar.attr('aria-valuenow');
        $bar.css('width', '0%').animate({
            width: width + '%'
        }, 1000);
    });

    // Tooltip untuk action buttons
    $('[data-toggle="tooltip"]').tooltip();

    // Loading overlay saat submit form
    $('form').on('submit', function() {
        $('.loading-overlay').fadeIn();
    });

    // Animasi untuk badges
    $('.badge').each(function() {
        $(this).css('opacity', '0').animate({
            opacity: 1
        }, 500);
    });

    // Highlight row yang baru dievaluasi
    if (window.location.hash) {
        const rowId = window.location.hash;
        $(rowId).addClass('highlight-row').fadeIn(500);
    }

    // Konfirmasi evaluasi dengan animasi
    $('.btn-evaluasi').on('click', function() {
        const kasusId = $(this).data('kasus-id');
        $(`#evaluasiModal${kasusId}`).modal('show');
    });

    // Notifikasi toast
    function showToast(message, type = 'info') {
        const toast = $(`
            <div class="toast-notification ${type}">
                <div class="toast-content">
                    <i class="fas fa-info-circle"></i>
                    <span>${message}</span>
                </div>
            </div>
        `).appendTo('body');

        setTimeout(() => {
            toast.addClass('show');
            setTimeout(() => {
                toast.removeClass('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }, 100);
    }

    // Filter table dengan animasi
    $('#searchInput').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $("#dataTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Filter button functionality
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        var filter = $(this).data('filter');
        console.log('Selected filter:', filter);
        
        if(filter === 'all') {
            $('#dataTable tbody tr').show();
        } else {
            $('#dataTable tbody tr').each(function() {
                var $row = $(this);
                var $priorityText = $row.find('.small.text-muted').text().trim().toLowerCase();
                
                if (filter === 'tinggi' && $priorityText.includes('tinggi')) {
                    $row.show();
                } else if (filter === 'sedang' && $priorityText.includes('sedang')) {
                    $row.show();
                } else if (filter === 'rendah' && $priorityText.includes('rendah')) {
                    $row.show();
                } else {
                    $row.hide();
                }
            });
        }
    });

    // Add this for debugging
    $(document).ready(function() {
        // Log all priority classes present in the table
        $('#dataTable tbody tr').each(function() {
            const classes = $(this).attr('class');
            console.log('Row classes:', classes);
        });
    });

    // Animasi untuk verification cards
    $('.verification-card').each(function(index) {
        $(this).css({
            'opacity': 0,
            'transform': 'translateY(20px)'
        }).delay(index * 100).animate({
            'opacity': 1,
            'transform': 'translateY(0)'
        }, 500);
    });

    // Enhance verifikasi modal
    $('[data-toggle="modal"]').on('click', function() {
        const targetModal = $($(this).data('target'));
        
        // Animate modal opening
        targetModal.on('show.bs.modal', function() {
            $(this).find('.modal-content')
                .css('transform', 'scale(0.7)')
                .animate({ transform: 'scale(1)' }, 200);
        });
        
        // Setup form validation
        const form = targetModal.find('form');
        form.on('submit', function() {
            const keterangan = $(this).find('textarea[name="keterangan"]');
            if (keterangan.val().length < 10) {
                alert('Keterangan harus minimal 10 karakter');
                return false;
            }
        });
    });

    // Contact button effects
    $('.contact-btn').hover(
        function() { $(this).find('i').addClass('fa-bounce'); },
        function() { $(this).find('i').removeClass('fa-bounce'); }
    );

    // Status badge animation
    $('.status-badge').each(function() {
        $(this).css('opacity', 0).animate({ opacity: 1 }, 500);
    });

    // Animasi untuk case cards
    $('.case-card').each(function(index) {
        $(this).css({
            'opacity': 0,
            'transform': 'translateY(20px)'
        }).delay(index * 150).animate({
            'opacity': 1,
            'transform': 'translateY(0)'
        }, 600);
    });

    // Tooltip untuk catatan yang terpotong
    $('.case-note').tooltip({
        title: function() {
            return $(this).text();
        }
    });

    // Animasi untuk status badges
    $('.status-badge').each(function(index) {
        $(this).css('opacity', 0)
            .delay(index * 100)
            .animate({ opacity: 1 }, 500);
    });

    // Enhanced table sorting
    $('#tableKonfirmasi, #tableDitolak').DataTable({
        "pageLength": 10,
        "ordering": true,
        "order": [[3, "desc"]], // Sort by date by default
        "columnDefs": [
            { "type": "date", "targets": 3 }
        ],
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data yang ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });

    // Smooth scroll to tables
    $('.nav-link').on('click', function(e) {
        if (this.hash !== "") {
            e.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 70
            }, 800);
        }
    });

    // Animasi untuk detail cards
    $('.detail-card').each(function(index) {
        $(this).css({
            'opacity': 0,
            'transform': 'translateY(20px)'
        }).delay(index * 200).animate({
            'opacity': 1,
            'transform': 'translateY(0)'
        }, 600);
    });

    // Tooltip untuk file attachments
    $('.btn-download').tooltip({
        title: 'Klik untuk mengunduh',
        placement: 'top'
    });

    // Animasi untuk description box
    $('.detail-description').css({
        'opacity': 0,
        'transform': 'scale(0.95)'
    }).delay(600).animate({
        'opacity': 1,
        'transform': 'scale(1)'
    }, 500);

    // Enhanced modal animation
    $('#evaluasiModal').on('show.bs.modal', function() {
        $(this).find('.modal-content')
            .css('transform', 'scale(0.7)')
            .animate({ transform: 'scale(1)' }, 300);
    });

    // Smooth scroll untuk navigasi
    $('.back-to-top').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 600);
    });

    // File preview hover effect
    $('.detail-attachment').hover(
        function() {
            $(this).find('.detail-attachment-icon').addClass('fa-bounce');
        },
        function() {
            $(this).find('.detail-attachment-icon').removeClass('fa-bounce');
        }
    );

    // Copy kode pengaduan dengan click
    $('.copy-code').click(function() {
        const code = $(this).data('code');
        navigator.clipboard.writeText(code).then(() => {
            showToast('Kode pengaduan berhasil disalin!', 'success');
        });
    });

    // Handling tombol kembali dengan animasi
    $('.btn-back').on('click', function(e) {
        e.preventDefault();
        const $body = $('body');
        
        // Tambahkan efek fade out
        $body.fadeOut(300, function() {
            window.history.back();
        });
    });

    // Tambahkan efek fade in saat halaman dimuat
    $(window).on('pageshow', function(event) {
        // Cek jika navigasi dari history
        if (event.originalEvent.persisted) {
            $('body').hide().fadeIn(300);
        }
    });

    // Simpan referrer URL saat masuk ke halaman detail
    if (document.referrer) {
        sessionStorage.setItem('previousPage', document.referrer);
    }

    // Profile Page Interactions
    $(document).ready(function() {
        // Animasi untuk profile card
        $('.profile-card').css({
            'opacity': 0,
            'transform': 'translateY(20px)'
        }).animate({
            'opacity': 1,
            'transform': 'translateY(0)'
        }, 600);

        // Custom file input untuk foto profil
        $('#foto_profil').on('change', function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Validasi form
        $('form').on('submit', function() {
            let isValid = true;
            $(this).find('input[required], select[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        });

        // Password strength indicator
        $('input[name="password"]').on('input', function() {
            const password = $(this).val();
            const strength = checkPasswordStrength(password);
            updatePasswordStrengthIndicator(strength);
        });

        // Smooth scroll untuk alerts
        if ($('.alert').length) {
            $('html, body').animate({
                scrollTop: $('.alert').offset().top - 100
            }, 500);
        }
    });

    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^A-Za-z0-9]/)) strength++;
        return strength;
    }

    // Update password strength indicator
    function updatePasswordStrengthIndicator(strength) {
        const indicator = $('.password-strength');
        const messages = ['Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
        const colors = ['danger', 'warning', 'info', 'success'];
        
        if (strength > 0) {
            indicator.html(`
                <div class="progress mt-2">
                    <div class="progress-bar bg-${colors[strength-1]}" 
                         style="width: ${strength*25}%">
                        ${messages[strength-1]}
                    </div>
                </div>
            `);
        }
    }

    // Dashboard Functionality
    $(document).ready(function() {
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            const dateString = now.toLocaleDateString('id-ID', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            $('#current-time').text(timeString);
            $('#current-date').text(dateString);
        }
        
        updateTime();
        setInterval(updateTime, 1000);

        // Initialize chart
        if($('#casesChart').length) {
            const ctx = document.getElementById('casesChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Proses', 'Selesai'],
                    datasets: [{
                        data: [chartData.pending, chartData.process, chartData.completed],
                        backgroundColor: [
                            'rgba(255, 164, 38, 0.8)',
                            'rgba(58, 186, 244, 0.8)',
                            'rgba(71, 195, 99, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 164, 38, 1)',
                            'rgba(58, 186, 244, 1)',
                            'rgba(71, 195, 99, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Animate stats cards on load
        $('.dashboard-card').each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            }).delay(index * 100).animate({
                'opacity': 1,
                'transform': 'translateY(0)'
            }, 500);
        });

        // Smooth scroll for recent cases list
        $('.recent-cases-list').on('scroll', function() {
            $(this).addClass('scrolling');
            clearTimeout($.data(this, 'scrollTimer'));
            $.data(this, 'scrollTimer', setTimeout(function() {
                $('.recent-cases-list').removeClass('scrolling');
            }, 250));
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Highlight row on hover
        const rows = document.querySelectorAll('.table tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.backgroundColor = '#f1f1f1';
            });
            row.addEventListener('mouseleave', () => {
                row.style.backgroundColor = '';
            });
        });
    });
});

function previewProfileImage() {
    const input = document.getElementById('foto_profil');
    const preview = document.getElementById('preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}