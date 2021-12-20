<?php include ('../view/header.php');
?>
<head>
    <title>Schedule Appointment</title>
    <link rel="stylesheet" type="text/css"
          href="../styles/schedule.css">
</head>

<div id='avail'>
<body>
    <main>
        <h1>Book Appointment For: <?php echo $serv['serviceName']; ?></h1>
                <br>
            <section>
                <legend>Check Availability</legend>
                <table>
                    <tr>
                        <th>Time-Slot</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>&nbsp;</th>
                    </tr>
                    <?php foreach($periods as $per): ?>
                    <tr>
                        <td><?php echo $per['slotID']; ?> </td>          
                        <td><?php echo $per['startTime'];  ?> </td>
                        <td><?php echo $per['endTime'];  ?> </td>
                        <td>
                            <form action="index.php" method="post">
                            <input type="hidden" name="action" value="check_availabilty"> 
                            <input type="hidden" name="req_time" value="<?php echo $per['slotID']; ?>">
                            <input type="text" name="req_date" required>
                             <?php echo $fields->getField('req_date')->getHTML(); ?><br>
                            <input type="Submit" value="Check">        
                            </form>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
          
            </section>
    </main>
</body>
</div>
<?php include ('../view/footer.php');?>


<!--<ul>
<li><?php //echo '<pre>'; var_export($periods); echo '</pre>'; ?></li>
</ul> -->