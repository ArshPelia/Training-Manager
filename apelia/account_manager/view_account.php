<?php include ('../view/header.php');?>
<head>
    <title>Account View</title>
    <link rel="stylesheet" type="text/css"
          href="../styles/account.css" />
</head>

<body>
    <main>
        <section id='account'>
            <div id="welcome">
                <h1>Welcome:</h1>
                <h2><?php echo ucwords($user['firstName']),' ', ucwords($user['lastName']); ?></h2>
                <img src="<?php echo $user['picPath']; ?>">
                <form action="." method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload"> 
                    <h3>Upload a Profile pic: </h3>
                    <input type="file" name="file1" required><br>
                    <input type="submit" value="Upload">
                </form>
            </div>
            <fieldset id="playerinfo">
                <legend>Personal Information</legend>
                 <form action="." method="post">
                    <input type="hidden" name="action" value="update"> 
                <label>First Name:</label>
                    <input type="text" name="fname" value="<?php echo htmlspecialchars($user['firstName']); ?>">
                        <?php echo $fields->getField('fname')->getHTML(); ?><br>
                <label>Last Name:</label>
                    <input type="text" name="lname" value="<?php echo htmlspecialchars($user['lastName']); ?>">
                        <?php echo $fields->getField('lname')->getHTML(); ?><br>
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                        <?php echo $fields->getField('email')->getHTML(); ?><br>
                <label>Phone Number:</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                        <?php echo $fields->getField('phone')->getHTML(); ?><br>
                <label>Password: </label>
                <input type="password" name="pword">
                        <?php echo $fields->getField('pword')->getHTML(); ?><br>
                <label>Verify Password:</label>
                    <input type="password" name="verify">
                        <?php echo $fields->getField('verify')->getHTML(); ?><br>
                <label> Position: </label>
                <select name="pos" default="<?php echo $user['posID']?>">
                    <?php foreach ($positions as $position) : ?>
                            <option><?php echo $position['positionName'] ?></option>
                    <?php endforeach; ?>
                </select><br>
                <input type="Submit" value="Update">
                </form>
            </fieldset>
            <br>
            <fieldset>
                <legend>Appointments</legend>
                <table>
                    <tr>
                        <th>Session Number</th>
                        <th>Session Type</th>
                        <th>Scheduled For</th>
                        <th>Completed</th>
                    </tr>
                    <?php foreach($appt as $appt): ?>
                    <tr>
                        <td><?php echo $appt['apptID']; ?> </td>          
                        <td><?php switch ($appt['servID']){
                                    case'T': 
                                        echo 'Technical';
                                        break;
                                    case'C': 
                                        echo 'Conditioning';
                                        break;
                                    case'P': 
                                        echo 'Physiotherapy';
                                        break;
                                    case'R': 
                                        echo 'Recovery/rehab';
                                        break;
                        }?> </td>
                        <td><?php echo $appt['apptDate'];  ?> </td>
                        <td><?php if($appt['completed'] == 0){
                                        echo 'No';
                                    }else{
                                    echo 'Yes';} ?> 
                        </td>
                    </tr>
                    <?php endforeach;?>
                 </table>
            </fieldset>
        <form action="index.php" method="post">
            <input type="submit" name="logout" value="Logout">
            <input type="hidden" name="action" value="logout">
        </form>
        </section>
    </main>
</body>

<?php include ('../view/footer.php');?>