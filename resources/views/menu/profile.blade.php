@extends('layout.app')
@section('title', 'My Profile')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>My Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">My Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <!-- Create Operator Page -->
        <section class="section profile">
            <div class="row">
                <div class="col-12">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <h2>{{ $user->name }}</h2>
                            <h3>
                                @if ($user->role == 'A')
                                    Admin
                                @elseif ($user->role == 'M')
                                    Master
                                @endif
                            </h3>
                        </div>
                        <div class="card-body profile-overview">
                            <h5 class="card-title">Detail Profile</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Nama</div>
                                <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Role</div>
                                <div class="col-lg-9 col-md-8">
                                    @if ($user->role == 'A')
                                        Admin
                                    @elseif ($user->role == 'M')
                                        Master
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Username</div>
                                <div class="col-lg-9 col-md-8">{{ $user->username }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                        Edit Profile
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                        Ubah Password
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="{{ route('dashboard.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-lg-3 col-form-label">Nama
                                                <span class="text-danger">*</span></label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="name" type="text" id="name" required
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name') ? old('name') : $user->name }}">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" id="email" required
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email') ? old('email') : $user->email }}">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="mobile_number" class="col-md-4 col-lg-3 col-form-label">Username
                                                <span class="text-danger">*</span></label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="username" type="text" id="username" required
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    value="{{ old('username') ? old('username') : $user->username }}">
                                                @error('username')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Ubah Profile</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form action="{{ route('dashboard.password') }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="row mb-3">
                                            <label for="password_old" class="col-md-4 col-lg-3 col-form-label">
                                                Password Sekarang
                                            </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password_old" type="password" id="password_old"
                                                    class="form-control @error('password_old') is-invalid @enderror">
                                                @error('password_old')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <label for="password_new" class="col-md-4 col-lg-3 col-form-label">
                                                Password Baru
                                            </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password_new" type="password" id="password_new"
                                                    class="form-control @error('password_new') is-invalid @enderror">
                                                @error('password_new')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="password_confirm" class="col-md-4 col-lg-3 col-form-label">
                                                Konfirmasi Password Baru
                                            </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password_confirm" type="password" id="password_confirm"
                                                    class="form-control @error('password_confirm') is-invalid @enderror">
                                                @error('password_confirm')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Ubah Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->
                                </div>
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')

@endsection
