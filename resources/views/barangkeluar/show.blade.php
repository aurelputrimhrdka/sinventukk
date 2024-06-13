@extends('layouts.adm-main')


@section('content')
    <div class="container">
    <div class="row">
            <div class="col-md-12">
		<div class="pull-left">
		    <h2>DETAIL BARANG KELUAR</h2>
		</div>
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>TANGGAL KELUAR</td>
                                <td>{{ $rsetBarangKeluar->tgl_keluar }}</td>
                            </tr>
                            <tr>
                                <td>JUMLAH KELUAR</td>
                                <td>{{ $rsetBarangKeluar->qty_keluar }}</td>
                            </tr>
                            <tr>
                                <td>BARANG</td>
                                <td>{{ $rsetBarangKeluar->barang->merk}}  {{ $rsetBarangKeluar->barang->seri }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12  text-center pt-3">
                <a href="{{ route('barangkeluar.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection