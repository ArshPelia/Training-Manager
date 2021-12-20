<?php include '../view/header.php';  ?>

<head>
    <title>Schedule Appointment</title>
    <link rel="stylesheet" type="text/css"
          href="../styles/schedule.css">
</head>

<body>
    <main>
        <section>
        <H1>Available Trainers for:  <?php echo $serv['serviceName']; ?></H1>
        <h2>At: <?php echo $request?> </h2>
        <?php if (count($trainers) == 0) : ?>
        <h3>Unfortunately there are no
        trainers available at your requested time. Please try Again.</h3>
        <?php else: ?>
        <table>
            <tr>
                <th>Staff Name</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach($trainers as $tr): ?>
            <tr>
                <td><?php echo $tr['firstName'],' ',$tr['lastName'] ?> </td>          
                <td>
                    <form action="index.php" method="post">
                    <input type="hidden" name="action" value="confirm"> 
                    <input type="hidden" name="train_id" 
                           value="<?php echo $tr['staffID']; ?>">
                    <input type="submit" value="Confirm Appointment">    
                </form>
                </td>
            </tr>
            <?php endforeach;?>         
        </table>
        <?php endif; ?>        
        </section>
    </main>
</body>
<?php include '../view/footer.php' ?>

