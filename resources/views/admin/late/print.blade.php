<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Keterlambatan {{ $student['nis'] }} | {{ $student['name'] }} {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap');

        body {
            font-family: 'Source Sans 3', sans-serif;
        }

        .title {
            text-align: center;
        }

        p {
            font-size: 12px;
        }

        .container {
            margin: 0 4em;
        }
    </style>
</head>

<body>
    <div class="title">
        <h5>SURAT PERNYATAAN <br>TIDAK AKAN DATANG TERLAMBAT KESEKOLAH</h5>
    </div>

    <div class="container">
        <p>NIS : {{ $student['nis'] }}</p>
        <p>Nama : {{ $student['name'] }}</p>
        <p>Rombel : {{ $student['rombel']['rombel'] }}</p>
        <p>NIS : {{ $student['rayon']['rayon'] }}</p>
        <br><br>
        <p>Dengan ini menyatakan bahwa saya telah melakukan pelanggaran tata tertib sekolah, yaitu terlambat datang ke sekolah sebanyak <b>3 Kali</b> yang mana hal tersebut masuk kedalam pelanggaran kedisiplinan. Saya berjanji tidak akan terlambat datang ke sekolah lagi. Apalagi saya terlambat datang ke sekolah lagi saya siap diberikan sanksi yang sesuai dengan peraturan sekolah.</p>
        <br><br>
        <p>Demikian surat pernyataan terlambat ini saya buat dengan penuh penyesalan.</p>
        <br><br><br>
        <p>Ceritanya tanda tangan...</p>
    </div>

</body>

</html>
