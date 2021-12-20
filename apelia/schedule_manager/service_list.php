<?php include ('../view/header.php');
include '../view/aside.php'?>
<head>
    <title>Service List</title>
    <link rel="stylesheet" type="text/css"
          href="../styles/schedule.css" />
</head>

<html>
<body>
    <main>
        <h1>Select Session Type</h1>
        <section>
            <table>
                <tr>
                <th>Service Type</th>
                <th>&nbsp;</th>
                </tr>
            <?php foreach ($services as $serv) : ?>
            <tr>
             <td><?php echo $serv['serviceName']; ?></td>
             <td>
                <form action="index.php" method="post">
                <input type="hidden" name="action" value="select_service">
                <input type="hidden" name="serv_id"
                           value="<?php echo $serv['servID']; ?>">
                <input type="submit" value="Select">
                </form>
             </td>
            </tr>
            <?php endforeach; ?>
            </table>
            <br>
        </section>       
    </main>
</body>
</html>
<?php include ('../view/footer.php');?>
