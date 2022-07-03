<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #D6EEEE;
    }
</style>
<table class="table table-bordered table-md" id="table">
    <table>
        <thead>
            <h2>Data Pembelian</h2>
        </thead>
    </table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah Produk</th>
            <th>Kategori</th>
            <th>Nama Perusahaan</th>
            <th>Total Bayar</th>
        </tr>
    </thead>
    <tbody class="purchase">
        @foreach ($purchase as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->goods_name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ $row->category }}</td>
                <td>{{ $row->company }}</td>
                <td>{{ $row->pay_total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
