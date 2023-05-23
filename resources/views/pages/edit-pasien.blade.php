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
                                    <th scope="col">Kolesterol</th>
                                    <th scope="col">Kreatinin</th>
                                    <th scope="col">Gula Darah Puasa</th>
                                    <th scope="col">Gula Darah Sewaktu</th>
                                    <th scope="col">Gula Darah 2 jam PP</th>
                                    <th scope="col">hbA1c</th>
                                    <th scope="col">Log Data</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($lab as $l)
                                    <tr>
                                        <td scope="row">
                                            {{ $l->kolesterol}} mg/dl
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
                                    <th scope="col">Stok Pada Pasien</th>
                                    <th scope="col">TanggaL Pemberian Obat</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($obat as $o)
                                    <tr>
                                        <th scope="row">
                                            {{ $o->nama_obat}}
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
                    <h4 class="card-htitle">DRP Pasien</h4>

                    <h4> Pertanyaan</h4>
                    <span class="dpasien">
                        Jawaban Pasien
                    </span>

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
                                <label for="inputname" class="col-sm-5 col-form-label">Kreatinin</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="kr" oninput="numberOnly(this.id);" name="kreatinin" value="{{ $l->kreatinin }}" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">µmol/L</label>
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
                                <label for="inputname" class="col-sm-5 col-form-label">Kreatinin</label>
                                <div class="align-items-end col-sm-4">
                                  <input type="name" class="form-control int-lbl" id="kr" oninput="numberOnly(this.id);" name="kreatinin" required>
                                </div>
                                <label for="inputname" class="col-sm-3 col-form-label">µmol/L</label>
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
                            <label for="inputname" class="col-sm-4 col-form-label">Jumlah Konsumsi per Hari</label>
                            <div class="align-items-end col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="dosis_harian" id="dosis_harian1" value="1" required>
                                    <label class="form-check-label" for="dosis_harian1">
                                      1
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="dosis_harian" id="dosis_harian2" value="2" required>
                                    <label class="form-check-label" for="dosis_harian2">
                                      2
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="dosis_harian" id="dosis_harian3" value="3" required>
                                    <label class="form-check-label" for="dosis_harian3">
                                      3
                                    </label>
                                </div>
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

                          <div class="mb-3 row">
                            <label for="inputname" class="col-sm-4 col-form-label">Waktu Konsumsi</label>
                            <div class="align-items-end col-sm-8">
                                <input type="text" name="waktu" class="form-control int-lbl" onfocus="(this.type='time')" onblur="if(!this.value)this.type='text'" required>
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
                            <label for="inputname" class="col-sm-4 col-form-label">Resep Oleh</label>

                            <div class="align-items-end col-sm-8">
                                <label for="inputname" class="col-form-label">{{ auth()->user()->name }}</label>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label for="inputname" class="col-sm-4 col-form-label">Jumlah Obat</label>
                            <div class="align-items-end col-sm-3">
                              <input type="text" name="jumlah_obat" class="form-control int-lbl" id="bb" oninput="numberOnly(this.id);" name="bb" required>
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