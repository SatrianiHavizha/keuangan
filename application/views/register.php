<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create new Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/register.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

    <body class="background">
        <div class="card shadow custom-card mx-auto">
            <div class="card-body">
                <h3 class="fw-bold">New Account</h3>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>


                <form method="post" action="<?= site_url('auth/register'); ?>">
                    <div class="mb-3 mt-4">
                        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3 shadow">
                        <select name="role" class="form-select" required>
                            <option value="">Login as</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Create</button>
                    <div class="text-center" style="font-size: 14px;">
                        <p>already have an account? <a href="<?= site_url('auth/login'); ?>" class="text-decoration-none">Login here</a></p>
                    </div>
                </form>
            </div>

            <footer>
                <p>&copy; 2025 Data Keuangan. All Rights Reserved.</p>
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>