<?php 
    function fetch_to_array($query,$con){
        $cursor=mysqli_query($con,$query);
        $dataBuffer=[];
        
        while($record = mysqli_fetch_assoc($cursor) ){
            array_push($dataBuffer,$record);
        }
        return $dataBuffer;
    }

?>