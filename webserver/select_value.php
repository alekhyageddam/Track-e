<?php
if(isset($_POST['submit'])){
    if(!empty($_POST['select'])) {
        $timeFrame = $_POST['select'];
         echo "You have selected " .$timeFrame;
         echo "<br>";
    }
}
?>