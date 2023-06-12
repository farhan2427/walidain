<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laporan Keuangan</title>
</head>
<body>

<style type="text/css">
    body{
      font-size: 11pt;
    }
    .table, .table td {
      border: 1px solid; 
    }

    .table th {
      background: #3A9BDC;
      border: 1px solid;
    }

    .table {
      border-collapse: collapse;
    }
  </style>
  <center>
    <font size="5"><b>TA'MIR MASJID AL-WALIDAIN</b></font><br>
    <font size="4"><b>LAPORAN KEUANGAN</b></font><br>
    <font size="2"><i>Jln. Raya Pulung-Ponorogo, Utara Pom Bensin Sidoharjo<i></font><br>
  </center>

<br>
<br>
  <table style="width: 50%">
    <tr>
      <td width="40%">DARI TANGGAL</td>
      <td width="5%" class="text-center">:</td>
      <td>{{ date('d-m-Y',strtotime($_GET['dari'])) }}</td>
    </tr>
    <tr>
      <td width="40%">SAMPAI TANGGAL</td>
      <td width="5%" class="text-center">:</td>
      <td>{{ date('d-m-Y',strtotime($_GET['sampai'])) }}</td>
    </tr>
    <tr>
      <td width="40%">KATEGORI</td>
      <td width="5%" class="text-center">:</td>
      <td>
        @php
        $id_kategori = $_GET['kategori'];
        @endphp

        @if($id_kategori == "")
        @php
        $kat = "SEMUA KATEGORI";
        @endphp
        @else
        @php
        $katt = DB::table('kategori')->where('id',$id_kategori)->first();
        $kat = $katt->kategori
        @endphp
        @endif

        {{$kat}}
      </td>
    </tr>
  </table>

  <br>

  <table class="table" width="100%">
    <thead>
      <tr>
        <th rowspan="2" class="text-center" width="1%">NO</th>
        <th rowspan="2" class="text-center" width="9%">TANGGAL</th>
        <th rowspan="2" class="text-center">KATEGORI</th>
        <th rowspan="2" class="text-center">KETERANGAN</th>
        <th colspan="2" class="text-center">JENIS</th>
      </tr>
      <tr>
        <th class="text-center">PEMASUKAN</th>
        <th class="text-center">PENGELUARAN</th>
      </tr>
    </thead>
    <tbody>
      @php
      $no = 1;
      $saldo = 0;
      $total_pemasukan = 0;
      $total_pengeluaran = 0;
      @endphp
      @foreach($transaksi as $t)
      <?php 
        if($t->jenis == "Pemasukan"){
          $saldo += $t->nominal;
        }else{
          $saldo -= $t->nominal;
        }
      ?>
      <tr>
        <td class="text-center">{{ $no++ }}</td>
        <td class="text-center">{{ date('d-m-Y', strtotime($t->tanggal )) }}</td>
        <td>{{ $t->kategori->kategori }}</td>
        <td>{{ $t->keterangan }}</td>
        <td class="text-center">
          @if($t->jenis == "Pemasukan")
          {{ "Rp.".number_format($t->nominal).",-" }}
          @php $total_pemasukan += $t->nominal; @endphp
          @else
          {{ "-" }}
          @endif
        </td>
        <td class="text-center">
          @if($t->jenis == "Pengeluaran")
          {{ "Rp.".number_format($t->nominal).",-" }}
          @php $total_pengeluaran += $t->nominal; @endphp
          @else
          {{ "-" }}
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4" class="text-bold text-right"><b>TOTAL</b></td>
        <td class="text-center"><b>{{ "Rp.".number_format($total_pemasukan).",-" }}</b></td>
        <td class="text-center"><b>{{ "Rp.".number_format($total_pengeluaran).",-" }}</b></td>
      </tr>
    </tfoot>
  </table>

</body>
</html>