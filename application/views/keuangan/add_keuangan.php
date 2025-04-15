<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add Transaction</h1>

        <form method="post" action="<?php echo site_url('keuangan/save'); ?>">
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Description</label>
                <input type="text" name="deskripsi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Amount</label>
                <input type="number" name="jumlah" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Date</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
