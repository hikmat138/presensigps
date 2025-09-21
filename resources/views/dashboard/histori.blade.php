@extends ('layouts.presensi')

@section('title', 'Histori')
@section('header')
<div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori</div>
        <div class="right"></div>
</div>
<style>
.histori-container {
    padding: 20px;
}

/* Styling untuk select */
.form-control {
    height: 50px;
    font-size: 16px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    border: 1px solid #ddd;
    transition: all 0.2s ease-in-out;
}

/* Saat focus */
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59,130,246,.25);
}

/* Supaya form group lebih lega */
.form-group {
    margin: 0 auto;
    max-width: 400px; /* biar gak terlalu panjang */
}
#bulan {
    width: 350px;
    min-width: 100px;
    padding: 8px;
}
#tahun {
    width: 350px;
    min-width: 100px;
    padding: 8px;
}
</style>
@endsection

@section('content')
<div class="row histori-container" style="margin-top:70px">
    <div class="col">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                <select name="bulan" id="bulan" class="form-control">
                <option value="bulan"> bulan </option>
                @for ($i=1;$i<=12 ;$i++)
                    <option value="{{$i}}" {{date('m') == $i ? 'selected':''}}>{{$namabulan[$i]}}</option>
                @endfor
                </select>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-group">
                <select name="bulan" id="tahun" class="form-control">
                <option value="Tahun"> Tahun  </option>
                @php
                $tahunmulai = 2019;
                $tahunskrg = date("Y");
                @endphp
                @for ($tahun=$tahunmulai; $tahun <= $tahunskrg;$tahun++)
                <option value="{{$tahun}}"{{date('Y') == $tahun ? 'selected':''}}>{{$tahun}}</option>
                @endfor
                </select>
                </div>
            </div>
        <div class="row" style="margin-top:2rem">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary" id="getdata" style="width:350px">
                    <ion-icon name="search-outline"></ion-icon> Cari
                    </button>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" id="showhistori">

    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function(){
        $("#getdata").click(function(e){
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        $.ajax({
            type:'post',
            url:'/gethistori',
            data:{
                _token:"{{csrf_token()}}",
                bulan:bulan,
                tahun:tahun,
            },
            cache:false,
            success:function(respond){
            $("#showhistori").html(respond);
            }
        })
        });
    });
</script>
@endpush