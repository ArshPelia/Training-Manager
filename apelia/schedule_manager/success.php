<?php 
include ('../view/header.php');?>
<head>
    <title>Future Appointments</title>
    <link rel="stylesheet" type="text/css"
          href="../styles/schedule.css">
</head>

<body>
    <main>
        <section>
        <h1>Scheduled Appointments: </h1>
        <table>
                    <tr>
                        <th>Session Number</th>
                        <th>Trainer Name</th>
                        <th>Session Type</th>
                        <th>Scheduled For</th>
                        <th>Completed</th>
                    </tr>
                    <?php foreach($appt as $appt): ?>
                    <tr>
                        <td><?php echo $appt['apptID']; ?> </td>          
                        <td><?php echo $tr['firstName'],' ',$tr['lastName'] ?></td>
                        <td><?php echo $serv['serviceName']  ?> </td>
                        <td><?php echo $appt['apptDate'];  ?> </td>
                        <td><?php if($appt['completed'] == 0){
                                        echo 'No';
                                    }else{
                                    echo 'Yes';} ?> 
                        </td>
                    </tr>
                    <?php endforeach;?>
        </table>
       </section> 
    </main>
</body>
<?php include ('../view/footer.php');?>
