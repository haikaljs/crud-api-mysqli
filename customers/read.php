<?php 

    header("Access-Control-Allow-Origin:*");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Method:GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    include("function.php");

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if($requestMethod == "GET"){

        if(isset($_GET['id'])){
            $customer = getCustomer($_GET);
            echo $customer;
        }
        elseif(isset($_GET['id']) !== 'id'){
            $data = [
                'status' => 404,
                'message' => "Customer not found",
                
                
            ];
            header("HTTP/1.0 404 Not found");
            echo json_encode($data);
        }
        else{
            $customerList = getCustomerList();
            echo $customerList;
        }
       
    }else{
        $data = [
            'status' => 405,
            'message' => $requestMethod . " " . "Method not allowed",
            
        ];
        header("HTTP/1.0 Method Not Allowed");
        echo json_encode($data);
    }

    function getCustomer($customerParams){

        global $conn;

        if($customerParams['id'] == null){
            return error422('Enter your customer id');
        }
        
        $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
        $query = "SELECT * FROM customers WHERE id='$customerId' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            if(mysqli_num_rows($result) == 1){
                $res = mysqli_fetch_assoc($result);
                $data = [
                    'status' => 200,
                    'message' => "Customer fetch successfully",
                    
                    
                ];
                header("HTTP/1.0 200 OK");
                echo json_encode($data);

            }
            else{
                $data = [
                    'status' => 404,
                    'message' => "Customer not found",
                    
                    
                ];
                header("HTTP/1.0 404 Not found");
                echo json_encode($data);
            }

        }else{
            $data = [
                'status' => 500,
                'message' => "Internal Server Error",
                
            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
        }
        
    }



?>