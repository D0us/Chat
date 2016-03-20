<?php
class database {

	function connect(){

	    $host='localhost'; 
	    $dbname='chat';
	    $user='chat';
	    $pass='MK2QHVahFmcwbest';

	    try {  
	      $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);  
	      $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	        return $dbh;
	    }
	    catch(PDOException $e) {  
	     echo 'ERROR: ' . $e->getMessage();
	    }   

	}

	function add_message($dbh, $body, $from) {
		$sql = "INSERT INTO messages (`body`, `from`) VALUES (:body, :fro);";
		$sth = $dbh->prepare($sql);
		$sth->bindparam(":body", $body);
		$sth->bindparam(":fro", $from);
		$sth->execute();
		// $sth->setFetchMode(PDO::FETCH_ASSOC);

		// $result = $sth->fetch();
		return;

	}

	function get_messages($dbh, $params) {

		$limit = $params['limit'];
		$offset = $params['offset'];

		$sql = "SELECT * FROM messages ORDER BY id DESC LIMIT :lim OFFSET :off";
		$sth = $dbh->prepare($sql);
		$sth->bindparam(":lim", $limit, PDO::PARAM_INT);
		$sth->bindparam(":off", $offset, PDO::PARAM_INT);
		$sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$result = $sth->fetchAll();

		return $result;
	}

	function add_image($dbh, $url) {

		$sql = "INSERT INTO images (`url`) VALUES (:url);";
		$sth = $dbh->prepare($sql);
		$sth->bindparam(":url", $url, PDO::PARAM_INT);
		$sth->execute();

		return;
	}

	function get_images($dbh, $params) {

		return 'hello';

		$limit = $params['limit'];
		$offset = $params['offset'];

		$sql = "SELECT * FROM images ORDER BY id DESC LIMIT :lim OFFSET :off";
		$sth = $dbh->prepare($sql);
		$sth->bindparam(":lim", $limit, PDO::PARAM_INT);
		$sth->bindparam(":off", $offset, PDO::PARAM_INT);
		$sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$result = $sth->fetchAll();

		return $result;
	}


}
?>
