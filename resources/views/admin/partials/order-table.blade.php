@if(isset($orders) && count($orders) > 0)
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Produk</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <!-- Isi tabel -->
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Tidak ada pesanan</div>
@endif