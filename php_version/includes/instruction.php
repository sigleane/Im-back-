<?php 
class CRUD {
    public function CREATE_DATA($db_connect, $instruction, $bind_type, $bind_params){
        $sql = $instruction;
        $stmt = mysqli_stmt_init($db_connect);
        if(mysqli_stmt_prepare($stmt, $sql)){
           mysqli_stmt_bind_param($stmt, $bind_type, ...$bind_params);
           mysqli_stmt_execute($stmt);
    
        }else{
            return mysqli_stmt_error($stmt);
        }
    }

    public function READ_DATA($db_connect, $instruction, $bind_type,$bind_params){
        $sql = $instruction;
        $stmt = mysqli_stmt_init($db_connect);
        if(mysqli_stmt_prepare($stmt, $sql)){
            if($bind_type !== NULL && $bind_params !== NULL){
                mysqli_stmt_bind_param($stmt, $bind_type, ...$bind_params);
            }
           
           mysqli_stmt_execute($stmt);
           
           $result = mysqli_stmt_get_result($stmt);
           $row = mysqli_fetch_all($result);
           return $row;
        }else{
            return mysqli_stmt_error($stmt);
        }
    }

    public function UPDATE_DATA($db_connect, $instruction, $bind_type,$bind_params){
        $sql = $instruction;
        $stmt = mysqli_stmt_init($db_connect);
        if(mysqli_stmt_prepare($stmt, $sql)){
           mysqli_stmt_bind_param($stmt, $bind_type, ...$bind_params);
           mysqli_stmt_execute($stmt);
    
        }else{
            return mysqli_stmt_error($stmt);
        }
    }

    public function DELETE_DATA($db_connect, $instruction, $bind_type,$bind_params){
        $sql = $instruction;
        $stmt = mysqli_stmt_init($db_connect);
        if(mysqli_stmt_prepare($stmt, $sql)){
           mysqli_stmt_bind_param($stmt, $bind_type, ...$bind_params);
           mysqli_stmt_execute($stmt);
    
        }else{
            return mysqli_stmt_error($stmt);
        }
    }
}

$db_instruction = new CRUD();


