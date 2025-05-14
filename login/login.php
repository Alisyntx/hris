<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS -->
    <link href="../public/css/output.css" rel="stylesheet">
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-[40%] flex h-73 bg-accentclr rounded-md">
        <div class="w-[40%] h-full border-r-2 border-primaryclr">
            <div class="w-full h-full flex justify-center">
                <img src="../public/image/logo.png" alt="" class="max-w-full h-auto object-contain">
            </div>
        </div>
        <div class="h-full w-[60%]">

            <div class="text-primaryclr mt-10 font-medium flex items-center justify-center font-popins text-2xl">
                Log In
            </div>
            <form class="flex flex-col mx-3" action="login_process.php" method="POST">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend  text-primaryclr">Username</legend>
                    <input type="text" placeholder="Type here" name="username" class="input input-accent w-full" />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend text-primaryclr">Password</legend>
                    <input type="password" placeholder="Type here" name="password" class="input input-accent w-full" />
                </fieldset>


                <div class="w-full mt-3">
                    <button class="btn w-20 btn-sm font-popins float-right">Log In</button>
                </div>

            </form>

        </div>
    </div>
    <!-- this is for log out sweat alert -->
    <?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Logged out',
                text: 'You have been logged out successfully.',
                timer: 2000,
                showConfirmButton: false
            });
            if (window.location.search.includes('logout=success')) {
                const url = new URL(window.location);
                url.searchParams.delete('logout');
                window.history.replaceState({}, document.title, url);
            }
        </script>
    <?php endif; ?>

    <!-- this is for log in sweat alert -->
    <?php if (isset($_GET['error'])): ?>
        <script>
            <?php if ($_GET['error'] === 'empty'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing fields',
                    text: 'Please enter both username and password.',
                    timer: 2000,
                    showConfirmButton: false
                });
            <?php elseif ($_GET['error'] === 'invalid'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Login failed',
                    text: 'Invalid username or password.',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Remove the query string from URL after displaying
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.delete('error');
                    window.history.replaceState({}, document.title, url.pathname);
                }
            <?php endif; ?>
        </script>
    <?php endif; ?>
</body>

</html>