<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
    //         $sql = "SELECT Username, Email, ApiKey FROM user";
    //         $statment = $this->db->prepare($sql);
    //         $statment->execute();
    //         $mainCount = $statment->rowCount();
    //         $result = $statment->fetchAll();
    //         if($mainCount==0) {
    //             return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
    //         }
    //         return $response->withJson(["status" => "success", "data" => $result], 200);
    // });

    $app->get('/getListCompany', function (Request $request, Response $response, array $args) use ($container) {
        $sql = "SELECT id,name FROM company";
        $statment = $this->db->prepare($sql);
        $statment->execute();
        $mainCount = $statment->rowCount();
        $result = $statment->fetchAll();
        if($mainCount==0) {
            return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
        }
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get('/getListUser', function (Request $request, Response $response, array $args) use ($container) {
        $sql = "SELECT id, first_name,last_name, email FROM user";
        $statment = $this->db->prepare($sql);
        $statment->execute();
        $mainCount = $statment->rowCount();
        $result = $statment->fetchAll();
        if($mainCount==0) {
            return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
        }
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get('/getBudgetCompany', function (Request $request, Response $response, array $args) use ($container) {
        $sql = "SELECT * FROM company_budget";
        $statment = $this->db->prepare($sql);
        $statment->execute();
        $mainCount = $statment->rowCount();
        $result = $statment->fetchAll();
        if($mainCount==0) {
            return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
        }
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get('/getUser/{id}', function (Request $request, Response $response, array $args) use ($container) {
        $id = trim(strip_tags($args["id"]));
        // die($id);
        $sql = 'SELECT id,first_name,email FROM user WHERE id=:id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $mainCount=$stmt->rowCount();
        $result = $stmt->fetchObject();
        if($mainCount==0) {
            return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
        }
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get('/getCompany/{id}', function (Request $request, Response $response, array $args) use ($container) {
        $id = trim(strip_tags($args["id"]));
        // die($id);
        $sql = 'SELECT * FROM company WHERE id=:id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $mainCount=$stmt->rowCount();
        $result = $stmt->fetchObject();
        if($mainCount==0) {
            return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
        }
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get('/getBudgetCompany/{id}', function (Request $request, Response $response, array $args) use ($container) {
        $id = trim(strip_tags($args["id"]));
        // die($id);
        $sql = 'SELECT id, amount FROM company_budget WHERE id=:id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $mainCount=$stmt->rowCount();
        $result = $stmt->fetchObject();
        if($mainCount==0) {
            return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
        }
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get('/getLogTransaction', function (Request $request, Response $response, array $args) use ($container) {
        $sql = "SELECT * FROM transaction";
        $statment = $this->db->prepare($sql);
        $statment->execute();
        $mainCount = $statment->rowCount();
        $result = $statment->fetchAll();
        if($mainCount==0) {
            return $this->response->withJson(['status' => 'error', 'message' => 'no result data.'],200); 
        }
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    //menyimpan data produk
    $app->post('/createCompany', function (Request $request, Response $response, array $args) {
        // Taking Request
        $input = $request->getParsedBody();
        $name=trim(strip_tags($input['name']));
        $address=trim(strip_tags($input['address']));
        // Process
        $sql = "INSERT INTO company(name,address) 
            VALUES(:name,:address)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $name);             
        $sth->bindParam("address", $address);                 
        $StatusInsert=$sth->execute();
        // Response
        if($StatusInsert){
            return $this->response->withJson(['status' => 'success','data'=>'success insert company.'],200); 
        } else {
            return $this->response->withJson(['status' => 'error','data'=>'error insert company.'],200); 
        }
    });

    $app->post('/createUser', function (Request $request, Response $response, array $args) {
        // Taking Request
        $input = $request->getParsedBody();
        $fname=trim(strip_tags($input['first_name']));
        $lname=trim(strip_tags($input['last_name']));
        $email = trim(strip_tags($input['email']));
        $account = trim(strip_tags($input['account']));


        // Process
        $sql = "INSERT INTO user(first_name,last_name,email,account) 
            VALUES(:first_name,:last_name,:email,:account)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("first_name", $fname);             
        $sth->bindParam("last_name", $lname);  
        $sth->bindParam("email", $email);
        $sth->bindParam("account", $account);               
        $StatusInsert=$sth->execute();
        // Response
        if($StatusInsert){
            return $this->response->withJson(['status' => 'success','data'=>'success insert user.'],200); 
        } else {
            return $this->response->withJson(['status' => 'error','data'=>'error insert user.'],200); 
        }
    });

    $app->post('/updateCompany/{id}', function (Request $request, Response $response, array $args) {
        // Taking Request
        $input = $request->getParsedBody();
        $id = trim(strip_tags($args["id"]));
        $name=trim(strip_tags($input['name']));
        $address = trim(strip_tags($input['address']));

        $sql = "UPDATE company SET name=:name, address=:address WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->bindParam("name", $name);             
        $sth->bindParam("address", $address); 

        $StatusUpdate=$sth->execute();
        if($StatusUpdate){
            return $this->response->withJson(['status' => 'success','data'=>'success update company.'],200); 
        } else {
            return $this->response->withJson(['status' => 'error','data'=>'error update company.'],200); 
        }
    });

    $app->post('/updateUser/{id}', function (Request $request, Response $response, array $args) {
        // Taking Request
        $input = $request->getParsedBody();
        $id = trim(strip_tags($args["id"]));
        //die($id);
        $fname=trim(strip_tags($input['first_name']));
        // die($first_name);
        $lname=trim(strip_tags($input['last_name']));
        $email = trim(strip_tags($input['email']));
        $account = trim(strip_tags($input['account']));

        $sql = "UPDATE `user` SET `first_name` = :first_name, `last_name` = :last_name, `email` = :email, `account`=:account WHERE id =:id";

        //$sql = "UPDATE user SET fname=:first_name, address=:address WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->bindParam("first_name", $fname);             
        $sth->bindParam("last_name", $lname);  
        $sth->bindParam("email", $email);
        $sth->bindParam("account", $account);  

        $StatusUpdate=$sth->execute();
        // die($StatusUpdate);

        if($StatusUpdate){
            return $this->response->withJson(['status' => 'success','data'=>'success update company.'],200); 
        } else {
            return $this->response->withJson(['status' => 'error','data'=>'error update company.'],200); 
        }
    });

    $app->get('/deleteCompany/{id}', function (Request $request, Response $response, array $args) {
            $id = trim(strip_tags($args["id"]));
            $sql = "DELETE FROM company WHERE id=:id";
            $sth = $this->db->prepare($sql);
            $sth->bindParam("id", $id);    
            $StatusDelete=$sth->execute();
            if($StatusDelete){
                return $this->response->withJson(['status' => 'success','data'=>'success delete company.'],200); 
            } else {
                return $this->response->withJson(['status' => 'error','data'=>'error delete company.'],200); 
            }
    });

    $app->get('/deleteUser/{id}', function (Request $request, Response $response, array $args) {
        $id = trim(strip_tags($args["id"]));
        $sql = "DELETE FROM user WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);    
        $StatusDelete=$sth->execute();
        if($StatusDelete){
            return $this->response->withJson(['status' => 'success','data'=>'success delete user.'],200); 
        } else {
            return $this->response->withJson(['status' => 'error','data'=>'error delete user.'],200); 
        }
    });
};
