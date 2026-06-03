<!DOCTYPE html>
<html>
<head>
    <title>List Kelompok</title>
</head>
<body>

<div style="margin-left:40px; margin-top:40px;">

    <h1>Data Kelompok</h1>

    @foreach ($nama_kelompok as $index => $item)

        Nama Kelompok {{ $index + 1 }} :
        {{ $item }}
        <br>

        Jumlah Anggota :
        {{ $jumlah_anggota[$index] }}
        <br>

        Event ID :
        {{ $event_id[$index] }}
        <br><br>

    @endforeach

</div>

</body>
</html>