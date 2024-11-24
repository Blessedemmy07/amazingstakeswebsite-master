<?php
    namespace App\Classes;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    use App\Facades\Http;  
    use App\Configs\ErrorLogger;  
    use App\Configs\DbConnection; 
    use PDO;

    class VipMatches {        
        protected $new_conn = "";
        protected $email = "";
        protected $password ="";

        public function __construct(){
            //initialize database connection
            $conn = new DbConnection();
            $this->new_conn = $conn->Connect();
        }

        public function FetchSpecialPlanMatches($date, $category) {
            try {
                $sql = "SELECT * FROM matches WHERE match_date = ? AND category = ? ORDER BY match_time ASC";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$date, $category]); 
                
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }  
        
        public function Fetch50OddsPlanMatches($date, $category) {
            try {
                $sql = "SELECT * FROM matches WHERE category = ? AND visible = '1' AND match_date >= ? ORDER BY match_date ASC";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$category, $date]); 
                
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        } 
        
        public function FetchInvestmentPlanMatches($date, $category) {
            try {
                $sql = "SELECT * FROM matches WHERE match_date = ? AND category = ? ORDER BY match_time ASC";
                
                $stmt = $this->new_conn->prepare($sql);
                $stmt->execute([$date, $category]); 
                
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $results;
        
            } catch (PDOException $e) {
                // Handle the error here, e.g., log it, display an error message, etc.
                echo "Query failed: " . $e->getMessage();
            }
        }  
    }
?>