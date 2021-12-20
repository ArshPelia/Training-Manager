<?php include ('../view/header.php');?>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css"
          href="../styles/account.css" />
</head>

<body>
    <main>
        <section id='login'>
            <fieldset>
                <legend>Please Enter Email and Password</legend>
            <h2>Member Login</h2><br>
            <form method="post" action="../account_manager/index.php">
                <input type="hidden" name="action" value="signin">
                <label for='email'>Email:</label>
                <input type="text" name="email" required> <br>
                <label for="password">Password:</label>
                <input type="password" name="pword" required>
                <input type="submit" value="Sign-In">
            </form>
            </fieldset>
            <label>Don't have an Account? </label>
            <form method="post" action="../account_manager/index.php">
                <input type="hidden" name="action" value="register_form">
           <input type="submit" value="Register Now">
            </form>
        </section>
    </main>
</body>

<?php include ('../view/footer.php');?>