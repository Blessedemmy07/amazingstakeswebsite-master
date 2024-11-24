<?php
    namespace App\Classes;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    use App\Facades\Http;  
    use App\Configs\ErrorLogger;  
    use App\Configs\DbConnection; 
    use PDO;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class VipPlans {        
        protected $new_conn = "";
        protected $email = "";
        protected $password ="";

        public function __construct(){
            //initialize database connection
            $conn = new DbConnection();
            $this->new_conn = $conn->Connect();
        }
        
        public function FetchVipPlans($type) {
            try {
                $sql = "SELECT * FROM `auto_update` WHERE type = ? AND plan = 'vip' ORDER BY amount ASC";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$type]); 
                
                $plans_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $plans_results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }       
        
        public function FetchSpecialPlans($type) {
            try {
                $sql = "SELECT * FROM `auto_update` WHERE type = ? AND plan = 'special' ORDER BY amount ASC";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$type]);
                
                $plans_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $plans_results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }       

        public function FetchExpertPlans($type) {
            try {
                $sql = "SELECT * FROM `auto_update` WHERE type = ? AND plan = 'expert' ORDER BY amount ASC";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$type]); 
                
                $plans_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $plans_results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }     
        
        public function FetchInvestmentPlans($type) {
            try {
                $sql = "SELECT * FROM `auto_update` WHERE type = ? AND plan = 'investments' ORDER BY amount ASC";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$type]); 
                
                $plans_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $plans_results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }    
        
        public function PaymentProPlans($plan) {
            try {
                $sql = "SELECT * FROM `auto_update` WHERE id = ?";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$plan]);
                
                $plans_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $plans_results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }   
        
        //Insert transaction logs
        public function TransactionLog($user_id, $email, $item_number, $plan, $item_name, $amount, $date_time, $country_ip, $actual_link) {
            try {
                $sql = "INSERT INTO transaction_log (user_id, email, reference_no, plan, details, amount, payment_means, date_time, ip_address, used_url) 
                        VALUES (?, ?, ?, ?, ?, ?, 'Paypal', ?, ?, ?)";
        
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$user_id, $email, $item_number, $plan, $item_name, $amount, $date_time, $country_ip, $actual_link]);
        
                return true;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Insertion failed: " . $e->getMessage();
                return false;
            }
        }      
        
        public function FetchTranscationLogs($user_id, $date_time) {
            try {
                $sql = "SELECT * FROM `transaction_log` WHERE user_id = ? AND date_time = ?";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$user_id, $date_time]);
                
                $plans_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $plans_results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }   

        function sendPaymentNotificationEmail($to, $name, $item_number, $amount, $sign, $date_time, $subject_include) {
            $mail = new PHPMailer(true);
            
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'alpacke.tech@gmail.com'; 
                $mail->Password = 'nilrqduvyzcbnfyr'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587; 
        
                // Recipients
                $mail->setFrom('no-reply@amazingstakes.com', 'Amazingstakes');
                $mail->addAddress($to);
                $mail->addBCC('supavgtdh@gmail.com'); // BCC address
        
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Payment Attempt Notification';
                $mail->Body = "
                    <img src='https://www.amazingstakes.com/images/logo.png' style='width:150px; height:150px;'><br><br>
                    Dear {$name},<br><br>
                    This is to notify you of your payment attempt for <b>{$subject_include} Plan</b> via <b>PayPal</b> with reference number: <b>{$item_number}</b> 
                    and amount: <b>{$sign}" . formatNumber($amount) . "</b> on <b>" . date_format(date_create($date_time), "d/m/Y h:i:s A") . "</b>.
                    <br><br>
                    Regards,<br>
                    amazingstakes Team,<br>
                    <a href='https://www.amazingstakes.com'>www.amazingstakes.com</a>";
                
                return  $mail->send();

                // echo "Email sent successfully!";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }               
    }
?>