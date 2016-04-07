<?php
class database {

	public $dbname = 'chat';

	function connect(){

	    $host	='localhost'; 
	    $dbname	='chat';
	    $user 	='chat';
	    $pass 	='1234';

	    try {  
	      $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);  
	      $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	        return $dbh;
	    }
	    catch(PDOException $e) {  
	     echo 'ERROR: ' . $e->getMessage();
	    }   

	}

	function add_message($dbh, $body, $from, $chatroom_id) {

		$chatroom_table = $chatroom_id . '_messages';

		$sql = "INSERT INTO $chatroom_table (`body`, `from`) VALUES (:body, :fro);";
		$sth = $dbh->prepare($sql);
		$sth->bindparam(":body", $body);
		$sth->bindparam(":fro", $from);
		$sth->execute();
		return;

	}

	function get_messages($dbh, $params) {

		$limit = $params['limit'];
		$offset = $params['offset'];
		$chatroom_table = $params['chatroom_id'] . '_messages';

		$sql = "SELECT * FROM $chatroom_table ORDER BY id DESC LIMIT :lim OFFSET :off";
		$sth = $dbh->prepare($sql);
		$sth->bindparam(":lim", $limit, PDO::PARAM_INT);
		$sth->bindparam(":off", $offset, PDO::PARAM_INT);
		$sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$result = $sth->fetchAll();

		return $result;
	}

	function add_image($dbh, $url, $chatroom_id) {

		$chatroom_table = $chatroom_id . '_images';

		$sql = "INSERT INTO $chatroom_table (`url`) VALUES (:url);";
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

		$dbh->beginTransaction();

		try {

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


					(string) $messages_table 	=  $result['id'] . '_messages';
					(string) $images_table 		= $result['id'] . '_images';

					$sql = "CREATE TABLE $images_table (
							`id` mediumint(9) NOT NULL AUTO_INCREMENT,
							`url` varchar(512) NOT NULL,
							`dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
							PRIMARY KEY (`id`,`url`),
							UNIQUE KEY `url` (`url`),
							UNIQUE KEY `id` (`id`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

							CREATE TABLE $messages_table (
							  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
							  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
							  `body` text NOT NULL,
							  `from` varchar(20) DEFAULT NULL,
							  PRIMARY KEY (`id`),
							  KEY `id` (`id`),
							  KEY `id_2` (`id`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

							";

					$sth = $dbh->prepare($sql);	
					$sth->execute();
					echo 'success!';
				}

		//if it fucks up roly poly 				
		} catch(PDOException $e) {

			$dbh->rollBack();
			$error_code = $e->getCode();
			$error_message = $e->getMessage();

			switch ($error_code) {
				case 23000:
					echo 'Chatroom name unavailable!';
				break;

				default:
					echo $error_message;
				break;
			}
		}
	}

	function get_chatrooms($dbh) {

		$sql = "SELECT * FROM chatrooms;";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$result = $sth->fetchAll();

		return $result;

	}


}
?>
