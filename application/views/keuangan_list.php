<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Keuangan</title>
</head>
<body>
    <h1>Data Keuangan</h1>
    <a href="<?= site_url('keuangan/add'); ?>">Tambah Transaksi</a>
    <table>
        <tr>
            <th>Jenis Transaksi</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
        </tr>
        <?php foreach ($keuangan as $item): ?>
        <tr>
            <td><?= $item->jenis_transaksi; ?></td>
            <td><?= $item->jumlah; ?></td>
            <td><?= $item->tanggal; ?></td>
            <td><?= $item->keterangan; ?></td>
            <td>
                <a href="<?= site_url('keuangan/edit/'.$item->id); ?>">Edit</a> |
                <a href="<?= site_url('keuangan/delete/'.$item->id); ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
