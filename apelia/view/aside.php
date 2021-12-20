<?php 
require_once('../model/service_db.php');


function get_staff_byservice(){
    $staffarr = array();
    for($i = 0; $i <=4; $i++){
        $staffarr[$i] = array();
    }
    
    foreach ($services as $id => $serv) :
        foreach ($staff as $id2 => $staff) : 
            $staffarr[$id][$id2] = $staff;
        endforeach;
    endforeach;
}

?>

<head>
    <link rel="stylesheet" type="text/css"
          href="../styles/schedule.css" />
</head>

    <body>
        <aside>
            <h2>Meet our Team</h2>
            <nav id="asidenav">
                <ul>
                   <?php foreach ($services as $serv) : ?>               
                   <li>
                       <a href="#">
                        <?php echo $serv['serviceName']; ?>
                           <i></i>
                       </a>  
                       <ul>
                           <?php $tr = get_serv_staff($serv['servID']); 
                               foreach($tr as $tr): ?>
                           <li>          
                            <?php echo $tr['firstName'], ' ', $tr['lastName'];?>
                           </li>
                           <?php endforeach; ?>
                       </ul>
                   </li>
                   <?php endforeach; ?>
               </ul>     
            </nav>
        </aside>
    </body>