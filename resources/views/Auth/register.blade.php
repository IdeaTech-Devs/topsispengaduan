<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <!-- Animated Background Shapes -->
    <div class="area">
        <ul class="circles">
            <li></li><li></li><li></li><li></li><li></li>
            <li></li><li></li><li></li><li></li><li></li>
        </ul>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10 col-md-11">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <!-- Logo dan Header -->
                                    <div class="text-center mb-4">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="mb-4" style="height: 80px;">
                                        <h1 class="h4 text-gray-900">Buat Akun Baru</h1>
                                        <p class="text-muted">Silakan lengkapi form di bawah ini</p>
                                    </div>

                                    <!-- Alert Messages -->
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            <ul class="mb-0 pl-4">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="close" data-dismiss="alert">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <!-- Registration Form -->
                                    <form class="user" method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <!-- Progress Steps -->
                                                <div class="progress-steps mb-4">
                                                    <div class="step active">
                                                        <span>1</span>
                                                        <p>Info Dasar</p>
                                                    </div>
                                                    <div class="step">
                                                        <span>2</span>
                                                        <p>Keamanan</p>
                                                    </div>
                                                    <div class="step">
                                                        <span>3</span>
                                                        <p>Role</p>
                                                    </div>
                                                </div>

                                                <!-- Step 1: Basic Info -->
                                                <div class="step-content" id="step1">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control1 form-control-user @error('name') is-invalid @enderror" 
                                                            name="name" value="{{ old('name') }}" required>
                                                        <label>Nama Lengkap</label>
                                                        @error('name')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-floating">
                                                        <input type="email" class="form-control1 form-control-user @error('email') is-invalid @enderror" 
                                                            name="email" value="{{ old('email') }}" required>
                                                        <label>Alamat Email</label>
                                                        @error('email')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-floating">
                                                        <input type="text" class="form-control1 form-control-user @error('telepon') is-invalid @enderror" 
                                                            name="telepon" value="{{ old('telepon') }}" required>
                                                        <label>Nomor Telepon</label>
                                                        @error('telepon')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Step 2: Security -->
                                                <div class="step-content d-none" id="step2">
                                                    <div class="form-floating">
                                                        <input type="password" class="form-control1 form-control-user @error('password') is-invalid @enderror" 
                                                            name="password" required>
                                                        <label>Password</label>
                                                        @error('password')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-floating">
                                                        <input type="password" class="form-control1 form-control-user" 
                                                            name="password_confirmation" required>
                                                        <label>Konfirmasi Password</label>
                                                    </div>

                                                    <div class="password-strength mt-2">
                                                        <div class="progress" style="height: 5px;">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                                        </div>
                                                        <small class="text-muted">Kekuatan Password: <span>Lemah</span></small>
                                                    </div>
                                                </div>

                                                <!-- Step 3: Role -->
                                                <div class="step-content d-none" id="step3">
                                                    <div class="role-cards mb-4">
                                                        <div class="role-card" data-role="kemahasiswaan">
                                                            <i class="fas fa-university mb-2"></i>
                                                            <h6>Kemahasiswaan</h6>
                                                            <p class="small text-muted">Akses untuk staf kemahasiswaan</p>
                                                        </div>
                                                        <div class="role-card" data-role="satgas">
                                                            <i class="fas fa-shield-alt mb-2"></i>
                                                            <h6>Satgas</h6>
                                                            <p class="small text-muted">Akses untuk anggota satgas</p>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="role" id="selected_role">

                                                    <div id="fakultas-container" class="d-none">
                                                        <select class="form-control1 form-control-user @error('fakultas') is-invalid @enderror" 
                                                            name="fakultas" id="fakultas">
                                                            <option value="" disabled selected>Pilih Fakultas</option>
                                                            <option value="Teknik">Fakultas Teknik</option>
                                                            <option value="Hukum">Fakultas Hukum</option>
                                                            <option value="Pertanian">Fakultas Pertanian</option>
                                                            <option value="Ilmu Sosial dan Ilmu Politik">Fakultas Ilmu Sosial dan Ilmu Politik</option>
                                                            <option value="Keguruan dan Ilmu Pendidikan">Fakultas Keguruan dan Ilmu Pendidikan</option>
                                                            <option value="Ekonomi dan Bisnis">Fakultas Ekonomi dan Bisnis</option>
                                                            <option value="Kedokteran dan Ilmu Kesehatan">Fakultas Kedokteran dan Ilmu Kesehatan</option>
                                                            <option value="Matematika dan Ilmu Pengetahuan Alam">Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Navigation Buttons -->
                                                <div class="form-navigation mt-4">
                                                    <button type="button" class="btn btn-secondary btn-user" id="prevBtn" style="display:none">
                                                        <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
                                                    </button>
                                                    <button type="button" class="btn btn-primary btn-user" id="nextBtn">
                                                        Selanjutnya<i class="fas fa-arrow-right ml-2"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-success btn-user" id="submitBtn" style="display:none">
                                                        <i class="fas fa-check mr-2"></i>Daftar Sekarang
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">
                                            <i class="fas fa-arrow-left mr-2"></i>Sudah punya akun? Login!
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
</body>

</html>
