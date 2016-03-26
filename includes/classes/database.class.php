<?php
class database {

	public $dbname = 'chat';

	function connect(){

	    $host	='localhost'; 
	    $dbname	='chat';
	    $user 	='chat';
	    $pass 	='MK2QHVahFmcwbest';

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

	function create_chatroom($dbh, $params) {

		$name = $params['name'];
		$type = $params['type'];

		$sql = "INSERT INTO chatrooms (`name`, `type`) VALUES (:name, :type);";
		$sth = $dbh->prepare($sql);	
		$sth->bindparam(":name", $name, PDO::PARAM_INT);
		$sth->bindparam(":type", $type, PDO::PARAM_INT);

		//if successful insertion, get id and create chatroom tables
		if ($sth->execute()) {
			$sql = "SELECT `id` FROM chatrooms WHERE `name` = :name";
			$sth = $dbh->prepare($sql);
			$sth->bindparam(":name", $name, PDO::PARAM_INT);
			$sth->execute();
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			$result = $sth->fetch();

			if (!is_null($result)) {

				// $messages_table = $this->dbname . '.' . $result['id'] . '_messages';
				// $images_table 	= $result['id'] . '_images';

				$sql = "CREATE TABLE :images_table (
						`id` mediumint(9) NOT NULL AUTO_INCREMENT,
						`url` varchar(512) NOT NULL,
						`dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`id`,`url`),
						UNIQUE KEY `url` (`url`),
						UNIQUE KEY `id` (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

						";

				$sth = $dbh->prepare($sql);	
				$sth->bindparam(":images_table", 'chat.loo', PDO::PARAM_INT);
				$sth->execute();

			}
			
		}


	}


}
?>
