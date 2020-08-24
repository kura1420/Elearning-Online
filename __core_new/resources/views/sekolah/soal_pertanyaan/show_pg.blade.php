@extends('layouts.app')

@section('titlePage') Pertanyaan @endsection

@section('addTitle') | Pertanyaan @endsection

@section('addCss')

@endsection

@section('addJs')

@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="alert alert-warning" role="alert" id="alertSuccess" style="display:none;">
                <strong>Informasi</strong> Pertanyaan berhasil tersimpan.
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card stacked-form">
                        <div class="card-header">
                            <h4 class="card-title">No. <strong id="nomor">{{ $soalPertanyaan->nomor }}</strong></h4>
                        </div>
                        <div class="card-body">
                            @php echo $soalPertanyaan->pertanyaan; @endphp
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card stacked-form">
                        <div class="card-header">
                            <div class="form-group row">
                                <label for="kunci_jawaban" class="col-sm-2 col-form-label">Kunci Jawaban</label>
                                <div class="col-sm-2">
                                    {{ strtoupper($benar) }}
                                </div>
                            </div>                         
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="jawaban_a" class="col-sm-1 col-form-label">A.</label>
                                <div class="col-sm-11">
                                    @php echo isset($soalPertanyaanJawaban[0]->jawaban) ? $soalPertanyaanJawaban[0]->jawaban : NULL; @endphp
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jawaban_b" class="col-sm-1 col-form-label">B.</label>
                                <div class="col-sm-11">
                                    @php echo isset($soalPertanyaanJawaban[1]->jawaban) ? $soalPertanyaanJawaban[1]->jawaban : NULL; @endphp
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jawaban_c" class="col-sm-1 col-form-label">C.</label>
                                <div class="col-sm-11">
                                    @php echo isset($soalPertanyaanJawaban[2]->jawaban) ? $soalPertanyaanJawaban[2]->jawaban : NULL; @endphp
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jawaban_d" class="col-sm-1 col-form-label">D.</label>
                                <div class="col-sm-11">
                                    @php echo isset($soalPertanyaanJawaban[3]->jawaban) ? $soalPertanyaanJawaban[3]->jawaban : NULL; @endphp
                                </div>
                            </div>

                            <div class="form-group row" style="{{ $soal->tipe_pilihan_ganda !== 'a-e' ? 'display:none;' : '' }}">
                                <label for="jawaban_e" class="col-sm-1 col-form-label">E.</label>
                                <div class="col-sm-11">
                                    @php echo isset($soalPertanyaanJawaban[4]->jawaban) ? $soalPertanyaanJawaban[4]->jawaban : NULL; @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('addModal')

@endsection