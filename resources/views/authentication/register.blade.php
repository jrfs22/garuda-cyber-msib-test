@extends('layouting.guest')

@section('title', 'Register')
@section('content')
    <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="{{ asset('assets/logo/garuda-cyber.png') }}" width="220" alt="">
                            </a>
                            <p class="text-center">Part Of <a target="_blank" href="https://garudacyber.co.id">Garuda Cyber Indonesia</a>

                            </p>
                            <form method="POST" action="{{ route('cek-register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="inputNama" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="inputNama"
                                        aria-describedby="emailHelp" placeholder="Masukkan nama">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="Masukkan email">
                                </div>
                                <div class="mb-4">
                                    <label for="referral" class="form-label">Referral Code</label>
                                    <input type="text" name="referral_code" class="form-control" id="referral" placeholder="Masukkan kode referral">
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Password">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Signup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
