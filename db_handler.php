<?php

class DbHandler {
	private $conn;

	function __construct() {
		require_once 'db_connect.php';
		
		$db = new DbConnect();
		$this->conn = $db->connect();
	}

	function getAllBooks($search) {
 		$stmt = $this->conn->prepare("SELECT book.isbn,title,GROUP_CONCAT(name) as a_name, availability FROM book,book_authors,authors WHERE book.isbn=book_authors.isbn and book_authors.author_id=authors.author_id and CONCAT(book.isbn, title, name) LIKE '%$search%' group by book.isbn");
        
	    if ($stmt->execute()) {
            
	     	$stmt->bind_result($isbn, $title,$a_name,$availability);
	     	$i=0;
            $book=[];
	     	while ($stmt->fetch()) {
	     		$book[$i]["isbn"] = $isbn;
	     		$book[$i]["title"] =$title;
                $book[$i]["a_name"] =$a_name;
				$book[$i]["availability"] =$availability;
	     		$i = $i + 1;
	     	}
	     	$stmt->close();
            if($book){
				return $book;
            }
			return null;
	    } 
	    else {
	     	echo "Unable to Execute.";
	    }
    }
	
	function addBorrower() {
		$ssn=mysqli_real_escape_string($this->conn, $_REQUEST['ssn']);
		$f_name=mysqli_real_escape_string($this->conn, $_REQUEST['fname']);
		$l_name=mysqli_real_escape_string($this->conn, $_REQUEST['lname']);
		$stmt = $this->conn->prepare("INSERT INTO `borrower`(`ssn`, `fname`, `lname`) VALUES ('$ssn','$f_name','$l_name')");
		if($stmt->execute()){
			$stmt->close();
			echo "Data added Successfully.";
		}
		else{
			echo "Data entry failed. " . mysqli_error($this->conn);
		}
	}
	
	function checkOut($card_id,$isbn){
		$response = array();
		$valid = $this->validCardId($card_id);
		$current_count =  $this->currentCount($card_id);
		
		if($valid){
			if($current_count<3){
				$stmt = $this->conn->prepare("INSERT INTO `book_loans`(`isbn`, `card_id`, `date_out`, `due_date`) VALUES ($isbn,$card_id,CURDATE(),DATE_ADD(CURDATE(), INTERVAL 14 DAY))");
				$stmt->execute();
				$stmt->close();
				$this->updateQuantity($isbn);
				$this->updateCountIssued($current_count,$card_id);
				$response["error"] = false;
				$response["message"] = "Book issued!";
			}
			else {
				$response["error"] = true;

				$response["message"] = "The user has already checked out 3 books.";
			}
		} 
		else {

			$response["error"] = true;

			$response["message"] = "Card ID does not exist.";
		}

		return $response;

	}
		
	
	function updateCountIssued($current_count,$card_id){
		$count=$current_count+1;
		$stmt = $this->conn->prepare("UPDATE borrower SET act_co = $count WHERE card_id = $card_id");
		$stmt->execute();
		$stmt->close();
	}
	function updateQuantity($isbn){
		$count=
		$stmt = $this->conn->prepare("UPDATE book SET availability = 0 WHERE isbn = $isbn");
		$stmt->execute();
		$stmt->close();

	}
	function validCardId($card_id){
		$stmt = $this->conn->prepare("SELECT card_id FROM borrower WHERE card_id = ?");
		$stmt->bind_param("s", $card_id);
		$stmt->execute();
		$stmt->store_result();
		$num_rows = $stmt->num_rows;
		$stmt->close();
		return ($num_rows == 1);
	}
	function currentCount($card_id){

		$stmt = $this->conn->prepare("SELECT act_co FROM borrower WHERE card_id = ?");

		$stmt->bind_param("s", $card_id);
		
		if($stmt->execute()){
			$stmt->bind_result($act_co);
			$stmt->fetch();
			$current = $act_co;
			$stmt->close();
			return $current;

		}	

	}
	
	
	function getBookLoans($search){
		$card_id=$this->getCardId($search);
		if(count($card_id)>0){
			$str="";
			foreach($card_id as $row){
				$str=$str.(string)$row.",";
			}
			$st=substr($str,0,-1);
			$stmt = $this->conn->prepare("SELECT * from book_loans where card_id in ($st) and date_in is null");
			if($stmt->execute()){

				$stmt->bind_result($loan_id,$isbn,$card_id,$date_out,$due_date,$date_in);
				$i=0;
				$loan=[];
				while ($stmt->fetch()) {
					$loan[$i]["loan_id"] = $loan_id;
					$loan[$i]["isbn"] = $isbn;
					$loan[$i]["card_id"] = $card_id;
					$loan[$i]["date_out"] = $date_out;
					$loan[$i]["due_date"] = $due_date;
					$i=$i+1;
				}
				$stmt->close();
			
				return $loan;
			}
			else {
				return "Unable to Execute.";
			}
		}
		else{
			
			return null;
		}
	}
	function getCardId($search){
		$stmt = $this->conn->prepare("SELECT distinct book_loans.card_id FROM book,borrower,book_loans WHERE book.isbn=book_loans.isbn and borrower.card_id=book_loans.card_id and CONCAT(book.isbn, borrower.fname,borrower.lname,book_loans.card_id) LIKE '%$search%' and book_loans.date_in is null");
		if($stmt->execute()){

			$stmt->bind_result($card_id);
			$i=0;
            $cardid=[];
	     	while ($stmt->fetch()) {
	     		$cardid[$i] = $card_id;
				$i=$i+1;
			}
			$stmt->close();

			return $cardid;

		}
	}
	
	function check_in($loan_id,$isbn,$card_id){
		$stmt = $this->conn->prepare("UPDATE book_loans SET date_in = CURDATE() WHERE loan_id = $loan_id");
		$stmt->execute();
		$stmt->close();
		$this->updateBookQuantity($isbn);
		$this->decCountIssued($card_id);
		$response["error"] = false;

		$response["message"] = "Book checked in successfully.";	
	
		return $response;
	}
	
	function updateBookQuantity($isbn){
		$stmt = $this->conn->prepare("UPDATE book SET availability = 1 WHERE isbn = $isbn");
		$stmt->execute();
						
		$stmt->close();
	}
	
	function decCountIssued($card_id){
		$cur=$this->currentCount($card_id);
		$cur=$cur-1;
		$stmt = $this->conn->prepare("UPDATE borrower SET act_co = $cur WHERE card_id = $card_id");
		$stmt->execute();
						
		$stmt->close();
	}
	

}

?>