<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/login.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

    <body class="background">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="fw-bold">Login</h3>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?php echo site_url('auth/login'); ?>">
                    <div class="mb-3 mt-4">
                        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    <div class="text-center" style="font-size: 14px;">
                        <p>Don't have an account? <a href="<?= site_url('auth/register'); ?>" class="text-decoration-none">Create a new account</a>
                        </p>
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