<?php
    namespace App\Classes;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    use App\Facades\Http;  
    use App\Configs\ErrorLogger;  
    use App\Configs\DbConnection; 
    use PDO;

    class Users {        
        protected $new_conn = "";
        protected $email = "";
        protected $password ="";

        public function __construct(){
            //initialize database connection
            $conn = new DbConnection();
            $this->new_conn = $conn->Connect();
        }

        public function UserLogin($email, $password) {    
            try {          
                $sql = "SELECT id, UPPER(fullName) as fullName, email, `password`, referby, referid, amount_earn, country, phone_number, dateCreated, active_plan, active_from, plan_expired, vip_active, vip_starts, vip_expires, guided_active, guided_starts, guided_ends, visible
                        FROM users WHERE email = ?";
        
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$email]);
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($results) {
                    // Compare user-provided password with the hashed password in the database
                    if (password_verify($password, $results["password"])) {
                        $response["status"] = "success";
                        $response["message"] = "User logged in successfully";
                        $response["data"] = $results["fullName"]; // returning fullName as per data available
                        
                        // Update last activity time stamp
                        $_SESSION['last_activity'] = time();
                        
                        // Set session variables for the logged-in user
                        $_SESSION["name"] = $results['fullName'];
                        $_SESSION["logged_in_user"] = $results['email'];
                        $_SESSION["logged_in_user_id"] = $results["id"];
                    } else {
                        $response["status"] = "failed";
                        $response["message"] = "Email or password is incorrect";
                        $response["data"] = "";
                    }                  
                } else {
                    $response["status"] = "failed";
                    $response["message"] = "User could not be found";
                    $response["data"] = "";
                }   
            } catch (PDOException $e) {
                // Initialize error logger
                $errLogger = new ErrorLogger();
                $errLogger->WriteError("Error: " . $e->getMessage());
        
                $response["status"] = "error";
                $response["message"] = "An error occurred, " . $e->getMessage();
            }
        
            header("Content-type:application/json;charset=UTF-8");
            return json_encode($response);          
        }
        

        public function CheckIfuserexists($conn,$email) {
            $response = false;
                  
            $sql = "SELECT `email` FROM users  WHERE email= ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($email));
            $results = $stmt->fetch();
            
            if(!empty($results)){
                $response = true;
            }    
    
            return $response;
        }

        public function CreateUser($fullName, $email, $phone_number, $country, $password) {
            // Check if user with that username already exists
            if ($this->CheckIfuserexists($this->new_conn, $email)) {
                $response['status'] = "Failed";
                $response['message'] = "A user with that email already exist";
            } else {
                $resp_message = "";
        
                // Updated SQL statement with the required fields
                $sql = "INSERT INTO users(fullName, email, phone_number, country, `password`, dateCreated, active_from, referby, referid, amount_earn, active_plan, plan_expired, vip_active, vip_starts, vip_expires, guided_active, guided_starts, guided_ends, visible) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
                // Generate Blowfish salt and hash
                $blowfish_salt = bin2hex(openssl_random_pseudo_bytes(22));
                $encrypted_pass = crypt($password, $blowfish_salt);
        
                $referby = ''; // Default empty referral
                if (isset($_POST['referby'])) {
                    $refercoded = $this->clean($_POST['referby']);
                    $checkrefercode = $this->new_conn->prepare("SELECT * FROM users WHERE referid = ?");
                    $checkrefercode->execute([$refercoded]);
                    $fetchrefer = $checkrefercode->fetch(PDO::FETCH_ASSOC);
                    $referby = $fetchrefer ? $fetchrefer['referid'] : '';
                }
        
                $stmt = $this->new_conn->prepare($sql);
        
                try {
                    $this->new_conn->beginTransaction();
                    $stmt->execute([
                        $fullName,                  // fullName
                        $email,                     // email
                        $phone_number,              // phone_number
                        $country,                   // country
                        $encrypted_pass,            // password
                        date("Y-m-d"),              // dateCreated
                        date("Y-m-d"),              // active_from
                        $referby,                   // referby
                        "Amz" . rand(),             // referid
                        0,                          // amount_earn (default to 0)
                        0,                          // active_plan (default to 0)
                        date("Y-m-d"),              // plan_expired (default to NULL)
                        0,                          // vip_active (default to 0)
                        date("Y-m-d"),              // vip_starts (default to NULL)
                        date("Y-m-d"),              // vip_expires (default to NULL)
                        0,                          // guided_active (default to 0)
                        date("Y-m-d"),              // guided_starts (default to NULL)
                        date("Y-m-d"),              // guided_ends (default to NULL)
                        1                           // visible (default to 1, assuming visibility is initially enabled)
                    ]);
        
                    $lastInsertId = $this->new_conn->lastInsertId();
        
                    // Commit Transaction
                    $this->new_conn->commit();
        
                    $resp_message = "User has been created successfully";
                    $response["status"] = "success";
                    $response["message"] = $resp_message;
        
                } catch (PDOException $e) {
                    // Rollback Transaction
                    $this->new_conn->rollback();
        
                    // Initialize error logger
                    $errLogger = new ErrorLogger();
                    $errLogger->WriteError("Error: " . $e->getMessage());
        
                    $response['status'] = "error";
                    $response['message'] = "Failed to create new user, " . $e->getMessage();
                }
            }
        
            header("Content-type:application/json;charset=UTF-8");
            return json_encode($response);
        }
        
        public function FetchAllUsers($user_email) {
            try {
                $sql = "SELECT id, fullName, email, referby, referid, amount_earn, country, phone_number, dateCreated,
                        active_plan, active_from, plan_expired, vip_active, vip_starts, vip_expires, guided_active, guided_starts,
                        guided_ends, visible FROM users WHERE email = ?";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$user_email]);
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                return $results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g. log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }        

        public function DisableUser($accAction,$id) {
            $sql = "UPDATE users SET visible = ? WHERE id = ?";
            $stmt = $this->new_conn->prepare($sql);

            try{
                $this->new_conn ->beginTransaction();

                $stmt->execute(array($accAction,$id));
    
                //Commit Transaction
                $this->new_conn->commit();

                $response["status"] = "success";
                $response["message"]= "User has been disabled Successfully";

            }catch(PDOException $e){
                //Roll back Transaction
                $this->new_conn->rollback();

                //intitialize error logger
                $errLogger = new ErrorLogger();

                $errLogger->WriteError("Error: ".$e->getMessage());

                $response['status'] ="error";
                $response['message'] = "Failed to disable user, ".$e->getMessage();
            } 

            header("Content-type:application/json;charset=UTF-8");
            return json_encode($response);  
        }

        public function UpdateActivePlan($email) {
            try {
                $sql = "UPDATE users SET active_plan = '0' WHERE email = ?";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$email]);
                
                return $stmt->rowCount() > 0; // Return true if rows were updated, false if none were updated
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
                return false;
            }
        }
        
        public function UpdateVipActive($email) {
            try {
                $sql = "UPDATE users SET vip_active = '0' WHERE email = ?";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$email]);
                
                return $stmt->rowCount() > 0; // Return true if rows were updated, false if none were updated
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
                return false;
            }
        }   
        
        public function UpdateUserProfile($fullName,$phone_number,$country, $email) {
            $sql = "UPDATE users SET fullName = ?, phone_number = ?, country = ? WHERE email = ?";
            $stmt = $this->new_conn->prepare($sql);

            try{
                $this->new_conn ->beginTransaction();

                $stmt->execute(array($fullName,$phone_number,$country,$email));
    
                //Commit Transaction
                $this->new_conn->commit();

                $response["status"] = "success";
                $response["message"]= "Profile successfully updated.\n\nThank you";

            }catch(PDOException $e){
                //Roll back Transaction
                $this->new_conn->rollback();

                //intitialize error logger
                $errLogger = new ErrorLogger();

                $errLogger->WriteError("Error: ".$e->getMessage());

                $response['status'] ="error";
                $response['message'] = "Failed to update user profile, ".$e->getMessage();
            } 

            header("Content-type:application/json;charset=UTF-8");
            return json_encode($response);  
        }

        public function UpdateActivePlanByDate($email) {
            try {
                $today = date("Y-m-d");

                $sql = "UPDATE users SET active_plan = '0',plan_expired = ? WHERE email = ?";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$today,$email]);
                
                return $stmt->rowCount() > 0; // Return true if rows were updated, false if none were updated
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
                return false;
            }
        }
    }
?>