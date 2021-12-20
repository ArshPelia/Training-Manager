<?php include ('../view/header.php');?>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css"
          href="../styles/account.css" />
</head>

<body>
    <main>
        <section id='reg'>
            <form action="index.php" method="post">
            <input type="hidden" name="action" value="register">
            <h1> Register New Player </h1>
                <legend>Personal Information</legend>
                <label>First Name:</label>
                <input type="text" name="fname">
                 <?php echo $fields->getField('fname')->getHTML(); ?><br>
                <label>Last Name:</label>
                <input type="text" name="lname">
                 <?php echo $fields->getField('lname')->getHTML(); ?><br>
                <label>Email:</label>
                <input type="text" name="email">
                 <?php echo $fields->getField('email')->getHTML(); ?><br>
                <label>Phone Number:</label>
                <input type="text" name="phone">
                 <?php echo $fields->getField('phone')->getHTML(); ?><br>
                <label>Password: </label>
                <input type="password" name="pword">
                 <?php echo $fields->getField('pword')->getHTML(); ?><br>
                <label>Verify Password:</label>
                <input type="password" name="verify">
                <?php echo $fields->getField('verify')->getHTML(); ?><br>
                <label> Position: </label>
                <select name="pos">
                    <?php foreach ($positions as $position) : ?>
                            <option><?php echo $position['positionName'] ?></option>
                    <?php endforeach; ?>
                </select><br> 
                <input type="Submit" value="Register">
            </form>
        </section>
    </main>
</body>
<?php include ('../view/footer.php');?>
