<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Pasien</title>
    @include('layouts.head')
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    @include('layouts.header')
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    @include('layouts.sidebar')
    </aside><!-- End Sidebar-->

  <main id="main" class="main">

    @if (session()-> has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row row-profile">
        <div class="col-3 mb-4" style="text-align: center">
            <img src="{{ asset('public/ImageUser/'.auth()->user()->avatar) }}" alt="Profile" class="rounded-circle pic-pasien">
        </div>
        <div class="col-9">
            @foreach ($data as $d)
                <h4>
                    {{ $d->name }}
                </h4>
                <label class="id_p">
                    {{ $d->user->username }} / UID
                </label><br>
            @endforeach

            <form action="/save-data-pasien" name="savepas" enctype="multipart/form-data" method="POST">
                @csrf
            <button type="submit" class="btn btn-int">
                Save Data
            </button> &nbsp;

            <a href="/detail-pasien-{{ $d->slug }}" type="button" class="btn btn-dcl">
                Discard
            </a>
        </div>
    </div>

    <div class="card-detail">
        <div class="card-hdetail">
            <ul class="nav nav-tabs">
                <li class="nav-ditem">
                    <button type="button" class="nav-link {{ Route::currentRouteName() == 'pasien' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#profile-overview">Data Diri</button>
                </li>
                <li class="nav-ditem">
                    <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-riwayat">Riwayat Medik</button>
                </li>
                <li class="nav-ditem">
                    <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-log-lab">Log Laboratorium</button>
                </li>
                <li class="nav-ditem">
                    <button type="button" class="nav-link {{ Route::currentRouteName() == 'set-timer' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#profile-time-medic">Waktu Konsumsi Obat</button>
                </li>
                <li class="nav-ditem">
                    <button type="button" class="nav-link {{ Route::currentRouteName() == 'keluhan-pasien' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#profile-drp">DRP</button>
                </li>
            </ul>
        </div>

        <div class="card-bdetail">

            <div class="tab-content pt-2">
                <div class="tab-pane fade show {{ Route::currentRouteName() == 'pasien' ? 'active' : '' }} profile-overview pt-3" id="profile-overview">
                    <div class="row">
                        <div class="col">

                            <h4 class="card-htitle">Informasi Pasien</h4>

                                @foreach ($data as $d)
                                    <input type="hidden" name="slug" value="{{ $d->slug }}">

                                    <h5 class="header-dpasien">Nomor Induk Kewarganegaraan</h5>
                                    <span class="dpasien">
                                        <input type="text" name="nik" class="form-control int-lbl" id="nik" oninput="numberOnly(this.id);" maxlength="16" value="{{ $d->nik }}" required>
                                    </span>

                                    <h5 class="header-dpasien">Nama Lengkap</h5>
                                    <span class="dpasien">
                                        <input type="text" name="name" class="form-control int-lbl" id="" value="{{ $d->name }}" required>
                                    </span>

                                    <h5 class="header-dpasien">Tanggal Lahir</h5>
                                    <span class="dpasien">
                                        <input name="tgl_lahir" type="text" class="form-control int-lbl" value="{{ $d->tgl_lahir }}" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" required>
                                    </span>

                                    <h5 class="header-dpasien">Gender</h5>
                                    <span class="dpasien">
                                        <input type="text" name="gender" class="form-control int-lbl" id="" value="{{ $d->gender }}" required>
                                    </span>

                                    <h5 class="header-dpasien">Emergency Contact</h5>
                                    <span class="dpasien">
                                        <input type="text" name="" class="form-control int-lbl" id="" value="{{ $d->user->phone_number }}" required>
                                    </span>

                                    <h5 class="header-dpasien">Helper</h5>
                                    <span class="dpasien">
                                        <input type="text" name="" class="form-control int-lbl" id="" value="{{ $d->user->phone_number }}" required>
                                    </span>
                                @endforeach
                            </div>

                            <div class="col">
                                <br><h4 class="card-htitle">Detail Obat Pasien</h4>
                                <h5>
                                    Estimasi Obat Habis :
                                </h5>

                                    <div class="d-flex align-items-center">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Nama Obat</th>
                                                    <th scope="col">Stok Pada Pasien</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($obat as $o)
                                                    <tr>
                                                        <th scope="row">
                                                            {{ $o->nama_obat}}
                                                        </th>
                                                        <td>
                                                            {{ $o->jumlah_obat }}
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                    <br><br><h4 class="card-htitle">Schedule Terdekat</h4>

                                    <h5>
                                        Tanggal Bertemu :
                                        @foreach ($data as $d)


                                            @if ($d->status == '0' )
                                                    - <br> <br>
                                                    <button type="button" class="btn btn-int" data-bs-toggle="modal" data-bs-target="#addSCH">Add Schedule</button>

                                            @else
                                                @foreach ($sch as $s)
                                                    {{ $s->schedule }} <br> <br>
                                                    <button type="button" class="btn btn-int" data-bs-toggle="modal" data-bs-target="#updateSCH">Edit Schedule</button>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </h5>

                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade profile-edit pt-3" id="profile-riwayat">
                        <h4 class="card-htitle">Riwayat Medik Pasien</h4>

                        @foreach ($data as $d)
                        <h5 class="header-dpasien">Berat Badan</h5>
                        <div class="row">
                            <div class="align-items-end col-1">
                                <input type="text" name="bb" class="form-control int-lbl" id="" value="{{ $d->bb }}" required>
                            </div>

                            <label for="inputname" class="col-1 col-form-label drh"> Kg</label>
                        </div>

                        <h5 class="header-dpasien">Tinggi Badan</h5>
                        <div class="row">
                            <div class="align-items-end col-1">
                                <input type="text" name="tb" class="form-control int-lbl" id="" value="{{ $d->tb }}" required>
                            </div>

                            <label for="inputname" class="col-1 col-form-label drh"> cm</label>
                        </div>

                        <h5 class="header-dpasien">Tekanan Darah</h5>
                        <table>
                            <td style="width: 7%">
                                <input type="text" name="td_tds" class="form-control int-lbl" id="" value="{{ $d->td_tds }}" required>
                            </td>
                            <td style="width: 1%">
                                <label for="inputname" class="col-1 col-form-label drh"> / </label>
                            </td>
                            <td style="width: 7%">
                                <input type="text" name="td_tdd" class="form-control int-lbl" id="" value="{{ $d->td_tdd }} " required>
                            </td>
                            <td>
                                <label for="inputname" class="col-1 col-form-label drh">  mmHg</label>
                            </td>
                        </table>

                        <h5 class="header-dpasien">Heart Rate</h5>
                        <div class="row">
                            <div class="align-items-end col-1">
                                <input type="text" name="h_rate" class="form-control int-lbl" id="" value="{{ $d->h_rate }}" required>
                            </div>
                        </div>

                        <h5 class="header-dpasien">History Life</h5>
                        <div class="row mb-3">
                            <div class="col-1">
                                <div class="row mb-3">
                                    <span>Merokok</span>
                                </div>
                                <div class="row mb-3">
                                    <span>Diet</span>
                                </div>
                                <div class="row">
                                    <span>Alkohol</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row mb-3">

                                    @if ($d->cigarettes == 'Yes')

                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes1" value="Yes" required checked>
                                                <label class="form-check-label" for="cigarettes1">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                                <label class="form-check-label" for="cigarettes2">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>

                                    @else

                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes1" value="Yes" required>
                                                <label class="form-check-label" for="cigarettes1">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required checked>
                                                <label class="form-check-label" for="cigarettes2">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>

                                    @endif

                                </div>

                                <div class="row mb-3">

                                    @if ($d->diet == 'Yes')

                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="diet" id="diet1" value="Yes" required checked>
                                                <label class="form-check-label" for="diet1">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="diet" id="diet2" value="No" required>
                                                <label class="form-check-label" for="diet2">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>

                                    @else

                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="diet" id="diet1" value="Yes" required>
                                                <label class="form-check-label" for="diet1">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="diet" id="diet2" value="No" required checked>
                                                <label class="form-check-label" for="diet2">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>

                                    @endif

                                </div>

                                <div class="row">

                                    @if ($d->alcohol == 'Yes')

                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alcohol" id="alcohol1" value="Yes" required checked>
                                                <label class="form-check-label" for="alcohol1">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alcohol" id="alcohol2" value="No" required>
                                                <label class="form-check-label" for="alcohol2">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>

                                    @else

                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alcohol" id="alcohol1" value="Yes" required>
                                                <label class="form-check-label" for="alcohol1">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alcohol" id="alcohol2" value="No" required checked>
                                                <label class="form-check-label" for="alcohol2">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>

                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach

                    </div>
                </form>

                    <div class="tab-pane fade pt-3" id="profile-log-lab">
                        <h4 class="card-htitle">Log Laboratorium Pasien</h4>

                        <div class="d-flex align-items-center">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Tekanan Darah</th>
                                    <th scope="col">Kolesterol</th>
                                    <th scope="col">HDL</th>
                                    <th scope="col">Kreatinin</th>
                                    <th scope="col">Gula Darah Puasa</th>
                                    <th scope="col">Gula Darah Sewaktu</th>
                                    <th scope="col">Gula Darah 2 jam PP</th>
                                    <th scope="col">hbA1c</th>
                                    <th scope="col">Klasifikasi</th>
                                    <th scope="col">Log Data</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($lab as $l)
                                    <tr>
                                        <td scope="row">
                                            {{ $l->td_tds}} / {{ $l->td_tdd }} mmHg
                                        </td>
                                        <td>
                                            {{ $l->kolesterol}} mg/dl
                                        </td>
                                        <td>
                                            {{ $l->hdl}} mg/dl
                                        </td>
                                        <td>
                                            {{ $l->kreatinin }} µmol/L
                                        </td>
                                        <td>
                                            {{ $l->gd_puasa }} mmol/L
                                        </td>
                                        <td>
                                            {{ $l->gd_sewaktu }} mg/dL
                                        </td>
                                        <td>
                                            {{ $l->gd_2jam_pp }} mg/dL
                                        </td>
                                        <td>
                                            {{ $l->hbA1c }} %
                                        </td>
                                        <td>
                                            {{ $l->klasifikasi }}
                                        </td>
                                        <td>
                                            {{ $l->created_at->isoformat('dddd, D MMMM Y') }}
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        @if (count($d->labTest($d->id)))
                            <button type="button" class="btn btn-int" data-bs-toggle="modal" data-bs-target="#editDataLab">
                                Edit Data
                            </button>
                        @else
                            <button type="button" class="btn btn-int" data-bs-toggle="modal" data-bs-target="#addDataLab">
                                Add Data
                            </button>
                        @endif

                    </div>

                    <div class="tab-pane fade show {{ Route::currentRouteName() == 'set-timer' ? 'active' : '' }} pt-3" id="profile-time-medic">
                        <h4 class="card-htitle">Waktu Konsumsi Obat Pasien</h4>

                        <div class="d-flex align-items-center">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Nama Obat</th>
                                    <th scope="col">Jumlah Konsumsi per-Hari</th>
                                    <th scope="col">Waktu Konsumsi</th>
                                    <th scope="col">Sesudah/Sebelum Makan</th>
                                    <th scope="col">Jumlah Obat</th>
                                    <th scope="col">Kekuatan Obat</th>
                                    <th scope="col">Bentuk Obat</th>
                                    <th scope="col">TanggaL Pemberian Obat</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($obat as $o)
                                    <tr>
                                        <th scope="row">
                                            <a href="#" class="psn_dtl" type="button" data-bs-toggle="modal" data-bs-target="#detMedic">
                                                {{ $o->nama_obat}}
                                            </a>
                                        </th>
                                        <td>
                                            {{ $o->dosis_harian }}
                                        </td>
                                        <td>
                                            {{ $o->waktu }}
                                        </td>
                                        <td>
                                            {{ $o->waktu_minum }}
                                        </td>
                                        <td>
                                            {{ $o->jumlah_obat }}
                                        </td>
                                        <td>
                                            {{ $o->kekuatan }}
                                        </td>
                                        <td>
                                            {{ $o->bentuk }}
                                        </td>
                                        <td>
                                            {{ $o->created_at->isoformat('dddd, D MMMM Y') }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn del-obat" data-bs-toggle="modal" data-bs-target="#delMedic">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="delMedic" tabindex="-1" aria-labelledby="delMedicLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="delMedicLabel">Delete Data</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/delete-med" name="delmed" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="slug" value="{{ $d->slug }}">
                                    @foreach ($obat as $o)
                                    <input type="hidden" name="id" value="{{ $o->id }}">
                                    @endforeach
                                    <div class="modal-body">
                                        Are you sure you want to delete this Data?
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-danger" type="submit">Delete Data</button>
                                </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                              </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-int" data-bs-toggle="modal" data-bs-target="#addMedicine">
                            Add Data
                        </button>

                </div>
                <div class="tab-pane fade show {{ Route::currentRouteName() == 'keluhan-pasien' ? 'active' : '' }} pt-3" id="profile-drp">
                    <div class="row">
                        <div class="col">

                            <h4 class="card-htitle">Informasi Pengobatan Pasien</h4>

                            <h5 class="header-dpasien">Indikasi Pasien  </h5>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes1" value="Yes" required>
                                        <label class="form-check-label" for="cigarettes1">
                                            Sesuai
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        <label class="form-check-label" for="cigarettes2">
                                            Tidak Sesuai
                                         </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="header-dpasien">Keamanan</h5>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes1" value="Yes" required>
                                        <label class="form-check-label" for="cigarettes1">
                                            Aman
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        <label class="form-check-label" for="cigarettes2">
                                            Tidak Aman
                                         </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="header-dpasien">Efikasi</h5>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes1" value="Yes" required>
                                        <label class="form-check-label" for="cigarettes1">
                                            Efektif
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        <label class="form-check-label" for="cigarettes2">
                                            Tidak Efektif
                                         </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="header-dpasien">Kepatuhan</h5>
                            <div class="row mb-3">
                                <div class="col-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes1" value="Yes" required>
                                        <label class="form-check-label" for="cigarettes1">
                                            Patuh
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        <label class="form-check-label" for="cigarettes2">
                                            Tidak Patuh
                                         </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="header-dpasien">Catatan Apt</h5>
                            <textarea name="catatan" class="form-control int-lbl" id="exampleFormControlTextarea1" rows="3" required></textarea>

                        </div>

                        <div class="col">
                            <h4 class="card-htitle">Resiko Pasien</h4>

                            <h5 class="header-dpasien">CVD Risk</h5>
                            <span class="dpasien">
                                [Hasil CVD Risk]
                            </span>

                            <h5 class="header-dpasien">BP Level</h5>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes1" value="Yes" required>
                                        <label class="form-check-label" for="cigarettes1">
                                            Pra HT
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        <label class="form-check-label" for="cigarettes2">
                                            Level 1
                                         </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        <label class="form-check-label" for="cigarettes2">
                                            Level 2
                                         </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        <label class="form-check-label" for="cigarettes2">
                                            Krisis HT
                                         </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="header-dpasien">Comorbid</h5>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <div class="mb-3">
                                        Ya
                                    </div>
                                    <div class="mb-3">
                                        Tidak
                                    </div>
                                    <div class="mb-3">
                                        Jenis Penyakit (Jika Ya)
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cigarettes" id="cigarettes2" value="No" required>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="align-items-end">
                                            <input type="text" name="name" class="form-control int-lbl" id="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="header-dpasien">Efek Samping Obat</h5>
                            <textarea name="catatan" class="form-control int-lbl" id="exampleFormControlTextarea1" rows="3" required></textarea>

                        </div>
                    </div>
                </div>
        </div><!-- End Bordered Tabs -->
    </div>

    {{-- Modal Add Schedule --}}
    <div class="modal fade" id="addSCH" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dellApolabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-input">
              <div class="modal-header modal-head">
                <h1 class="modal-title" id="addDataLabel">Set Schedule</h1>
              </div>
              <form action="/add-schedule" name="datalabsub" method="POST" enctype="multipart/form-data">
                  @csrf

                <input type="hidden" name="slug" value="{{ $d->slug }}">
                <div class="modal-body modal-bd">

                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-4 col-form-label">Tanggal Bertemu</label>
                            <div class="align-items-end col-sm-8">
                                -
                            </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-4 col-form-label">Set Schedule</label>
                        <div class="align-items-end col-sm-8">
                            <input name="schedule" type="text" class="form-control int-lbl" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-int" type="submit">Save Schedule</button>
            </form>
                    <button type="button" class="btn btn-dcl" data-bs-dismiss="modal">Close</button>
                </div>
          </div>
        </div>
    </div>

    {{-- Modal Edit Schedule --}}
    <div class="modal fade" id="updateSCH" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dellApolabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-input">
              <div class="modal-header modal-head">
                <h1 class="modal-title" id="addDataLabel">Set Schedule</h1>
              </div>
              <form action="/update-schedule" name="datalabsub" method="POST" enctype="multipart/form-data">
                  @csrf

                <input type="hidden" name="slug" value="{{ $d->slug }}">
                @foreach ($sch as $s)
                <input type="hidden" name="id" value="{{ $s->id }}">
                @endforeach
                <div class="modal-body modal-bd">

                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-4 col-form-label">Tanggal Bertemu</label>
                        @foreach ($data as $d)

                            @if ($d->status == '0' )
                                <div class="align-items-end col-sm-8">
                                    -
                                </div>
                            @else
                                <div class="align-items-end col-sm-8">
                                    @foreach ($sch as $s)
                                    <label for="inputname" class="col-sm-4 col-form-label">{{ $s->schedule }}</label>

                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-4 col-form-label">Set Schedule</label>
                        <div class="align-items-end col-sm-8">
                            <input name="schedule" type="text" class="form-control int-lbl" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-int" type="submit">Save Schedule</button>
            </form>
                    <button type="button" class="btn btn-dcl" data-bs-dismiss="modal">Close</button>
                </div>
          </div>
        </div>
    </div>

    {{-- Modal Edit Lab --}}
    <div class="modal fade" id="editDataLab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content modal-input">
            <div class="modal-header modal-head">
              <h1 class="modal-title" id="editDataLabel">Log Laboratorium</h1>
            </div>
            <form action="/update-datalab" name="datalabupd" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body modal-bd">
                    <div class="card-addData">
                        <div class="card-body-data">

                            @foreach ($data as $d)
                                <input type="hidden" name="slug" value="{{ $d->slug }}">
                            @endforeach

                            @foreach ($lab as $l)
                            <input type="hidden" name="id" value="{{ $l->id }}">
                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Kolesterol</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="kl" oninput="numberOnly(this.id);" name="kolesterol" value="{{ $l->kolesterol}}" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mg/dl</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">HDL</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="kl" oninput="numberOnly(this.id);" name="hdl" value="{{ $l->kolesterol}}" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mg/dl</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5   col-form-label">Tekanan Darah</label>

                                <div class="align-items-end col-2">
                                  <input type="text" class="form-control int-drh"  name="td_tds" id="td_tds" oninput="numberOnly(this.id);" maxlength="3" value="{{ $l->td_tds}}" required>
                                </div>

                                <label for="inputname" class="col-1 col-form-label drh"> /</label>

                                <div class="align-items-end col-sm-2">
                                    <input type="text" class="form-control int-drh"  name="td_tdd" id="td_tdd" oninput="numberOnly(this.id);" maxlength="3" value="{{ $l->td_tdd}}" required>
                                  </div>

                                <label for="inputname" class="col-sm-1 col-form-label">mmHg</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Kreatinin</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="kr" oninput="numberOnly(this.id);" name="kreatinin" value="{{ $l->kreatinin }}" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">U/L</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Gula Darah Puasa</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="gdp" oninput="numberOnly(this.id);" name="gd_puasa" value="{{ $l->gd_puasa }}" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mmol/L</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Gula Darah Sewaktu</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="gds" oninput="numberOnly(this.id);" name="gd_sewaktu" value="{{ $l->gd_sewaktu }}" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mg/dL</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Gula Darah 2 jam PP</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="gdpp" oninput="numberOnly(this.id);" name="gd_2jam_pp" value="{{ $l->gd_2jam_pp }}" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mg/dL</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">hbA1c</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="hb" oninput="numberOnly(this.id);" name="hbA1c" value="{{ $l->hbA1c }}" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">%</label>
                            </div>

                            @endforeach

                        </div>
                      </div>
                </div>

                <div class="modal-footer modal-foot mb-3">
                    <button type="submit " class="btn btn-int">Save</button>
                </form>
                <button type="button" class="btn btn-dcl" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>

    {{-- Modal Add Lab --}}
    <div class="modal fade" id="addDataLab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content modal-input">
            <div class="modal-header modal-head">
              <h1 class="modal-title" id="addDataLabel">Log Laboratorium</h1>
            </div>
            <form action="/submit-datalab" name="datalabsub" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body modal-bd">
                    <div class="card-addData">
                        <div class="card-body-data">

                            @foreach ($data as $d)
                                <input type="hidden" name="slug" value="{{ $d->slug }}">
                            @endforeach

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Kolesterol</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="kl" oninput="numberOnly(this.id);" name="kolesterol" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mg/dl</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">HDL</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="hdl" oninput="numberOnly(this.id);" name="hdl" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mg/dl</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5   col-form-label">Tekanan Darah</label>

                                <div class="align-items-end col-2">
                                  <input type="text" class="form-control int-drh"  name="td_tds" id="td_tds" oninput="numberOnly(this.id);" maxlength="3" required>
                                </div>

                                <label for="inputname" class="col-1 col-form-label drh"> /</label>

                                <div class="align-items-end col-sm-2">
                                    <input type="text" class="form-control int-drh"  name="td_tdd" id="td_tdd" oninput="numberOnly(this.id);" maxlength="3" required>
                                  </div>

                                <label for="inputname" class="col-sm-1 col-form-label">mmHg</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Kreatinin</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="kr" oninput="numberOnly(this.id);" name="kreatinin" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">U/L</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Gula Darah Puasa</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="gdp" oninput="numberOnly(this.id);" name="gd_puasa" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mmol/L</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Gula Darah Sewaktu</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="gds" oninput="numberOnly(this.id);" name="gd_sewaktu" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mg/dL</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">Gula Darah 2 jam PP</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="gdpp" oninput="numberOnly(this.id);" name="gd_2jam_pp" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">mg/dL</label>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputname" class="col-sm-5 col-form-label">hbA1c</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="hb" oninput="numberOnly(this.id);" name="hbA1c" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">%</label>
                            </div>

                        </div>
                      </div>
                </div>

                <div class="modal-footer modal-foot mb-3">
                    <button type="submit " class="btn btn-int">Save</button>
                </form>
                <button type="button" class="btn btn-dcl" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>

    {{-- Modal Add Medicine --}}
    <div class="modal fade" id="addMedicine" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content modal-input">
            <div class="modal-header modal-head">
              <h1 class="modal-title" id="addDataLabel">Input Data Obat</h1>
            </div>
            <form action="/submit-obat" name="submed" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body modal-bd">
              <div class="row">
                <div class="col">
                    <div class="card-addData">
                        <div class="card-body-data">
                          <h5 class="card-title addData-h">Konsumsi Obat</h5>
                          <hr class="int-l">

                            @foreach ($data as $d)
                                <input type="hidden" name="slug" value="{{ $d->slug }}">
                            @endforeach

                          <div class="mb-3 row">
                            <label for="inputname" class="col-sm-4 col-form-label">Nama Obat</label>
                            <div class="col-sm-8 align-items-end">
                                <select class="form-select form-control int-lbl" name="nama_obat">
                                    <option selected>Pilih Nama Obat</option>
                                    @foreach ($dataobat as $do)
                                        <option value="{{ $do->nama_obat }}">{{ $do->nama_obat }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label for="inputname" class="col-form-label">Jumlah Konsumsi per Hari</label>
                            <div class="input-group align-items-end">
                                <input type="text" id="dosis_harian" name="dosis_harian" class="form-control int-lbl" placeholder="Jumlah Konsumsi dalam 1 Hari" oninput="numberOnly(this.id);" aria-label="Recipient's username" aria-describedby="BJK" required>
                                <a href="#" class="btn btn-int" onclick="addFields()" id="BJK"> Tambah Data</a> <br>

                            </div>

                            <div class="align-items-end">
                                <br><div id="waktu-konsumsi"></div>
                            </div>

                          </div>

                          <div class="mb-3 row">
                            <label for="inputname" class="col-sm-4 col-form-label">Diminum Saat</label>
                            <div class="align-items-end col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="waktu_minum" id="waktu_minum1" value="Sebelum Makan" required>
                                    <label class="form-check-label" for="waktu_minum1">
                                      Sebelum Makan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="waktu_minum" id="waktu_minum2" value="Sesudah Makan" required>
                                    <label class="form-check-label" for="waktu_minum2">
                                      Sesudah Makan
                                    </label>
                                </div>
                            </div>
                          </div>

                        </div>
                      </div>
                </div>
                <div class="col">
                    <div class="card-addData">
                        <div class="card-body">
                          <h5 class="card-title addData-h">Detail Obat</h5>
                          <hr class="int-l">

                          <div class="mb-3 row">
                            <label for="inputname" class="col-sm-4 col-form-label">Jumlah Obat</label>
                            <div class="align-items-end col-sm-8">
                              <input type="text" name="jumlah_obat" class="form-control int-lbl" id="bb" oninput="numberOnly(this.id);" required>
                            </div>
                          </div>

                          <div class="col">
                            <label for="inputname" class="col-form-label">Kekuatan (Pilih Satu)</label>
                            <div class="align-items-end col-sm-6 row">

                                <div class="d-flex flex-column mb-3">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="p-2">mcg <br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kekuatan" id="kekuatan1" value="mcg" required>
                                            </div>
                                        </div>
                                        <div class="p-2">mg <br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kekuatan" id="kekuatan2" value="mg" required>
                                            </div>
                                        </div>
                                        <div class="p-2">g <br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kekuatan" id="kekuatan3" value="g" required>
                                            </div>
                                        </div>
                                        <div class="p-2">ml <br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kekuatan" id="kekuatan4" value="ml" required>
                                            </div>
                                        </div>
                                        <div class="p-2">% <br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kekuatan" id="kekuatan5" value="%" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col">
                            <label for="inputname" class="col-form-label">Bentuk Obat (Pilih Satu)</label>

                            <div class="mb-3 row align-items-end">
                                    <select class="form-select form-control int-lbl align-items-end" name="bentuk">
                                        <option selected>Pilih Bentuk Obat</option>
                                            <option value="Tablet">Tablet</option>
                                            <option value="Kapsul">Kapsul</option>
                                            <option value="Sirup">Sirup</option>
                                            <option value="" onclick="addlainnya()"><a href="#"  id="tbh" onclick="addlainnya()">Lainnya</a> </option>
                                    </select>
                            </div>

                            <div class="mb-3 row align-items-end">
                                <div id="lainnya"></div>
                            </div>

                        </div>

                        </div>
                      </div>
                </div>
              </div>

            </div>
            <div class="modal-footer modal-foot mb-3">
                    <button type="submit " class="btn btn-int">Save</button>
            </form>
              <button type="button" class="btn btn-dcl" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>

    {{-- Modal Detail Medicine --}}
    <div class="modal fade" id="detMedic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dellApolabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-input">
                <div class="modal-header modal-head">
                    <h1 class="modal-title" id="addDataLabel">Detail Obat</h1>
                </div>

                <div class="modal-body modal-bd">
                    @foreach ($obat as $o)

                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-6 col-form-label">Nama Generik</label>
                        <div class="align-items-end col-sm-6">
                            <label for="inputname" class="col-form-label">Nama Generik</label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-6 col-form-label">Nama Merk</label>
                        <div class="align-items-end col-sm-6">
                            <label for="inputname" class="col-form-label">{{ $o->nama_obat }}</label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-6 col-form-label">Kekuatan Obat</label>
                        <div class="align-items-end col-sm-6">
                            <label for="inputname" class="col-form-label">{{ $o->kekuatan }}</label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-6 col-form-label">Bentuk Sediaan</label>
                        <div class="align-items-end col-sm-6">
                            <label for="inputname" class="col-form-label">{{ $o->bentuk }}</label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-6 col-form-label">Jumlah Obat</label>
                        <div class="align-items-end col-sm-6">
                            <label for="inputname" class="col-form-label">{{ $o->jumlah_obat }}</label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputname" class="col-sm-6 col-form-label">Frekuensi</label>
                        <div class="align-items-end col-sm-6">
                            <label for="inputname" class="col-form-label">{{ $o->dosis_harian }} / {{ $o->wkatu }}</label>
                        </div>
                    </div>

                    @endforeach
                </div>

                <div class="modal-footer modal-foot justify-content-end">
                    <button type="button" class="btn btn-dcl" data-bs-dismiss="modal">Close</button>
                </div>

          </div>
        </div>
    </div>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    @include('layouts.footer')
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="Admin/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="Admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="Admin/vendor/chart.js/chart.min.js"></script>
  <script src="Admin/vendor/echarts/echarts.min.js"></script>
  <script src="Admin/vendor/quill/quill.min.js"></script>
  <script src="Admin/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="Admin/vendor/tinymce/tinymce.min.js"></script>
  <script src="Admin/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="Admin/js/main.js"></script>

</body>

</html>
