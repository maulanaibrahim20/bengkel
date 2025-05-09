<div>
    <h5>Detail Kendaraan</h5>
    <p><strong>Nama Pemilik:</strong> {{ $motorcycle->user->name ?? '-' }}</p>
    <p><strong>Plat Nomor:</strong> {{ $motorcycle->plate }}</p>
    <p><strong>Tipe:</strong> {{ $motorcycle->type }}</p>
    <p><strong>Merk:</strong> {{ $motorcycle->brand }}</p>
    <p><strong>Tahun:</strong> {{ $motorcycle->year }}</p>
    <p><strong>Warna:</strong> {{ $motorcycle->color }}</p>
</div>