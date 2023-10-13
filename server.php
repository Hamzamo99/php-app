<?php
include ('vendor/autoload.php');

use prodigyview\media\Video;
use prodigyview\util\FileManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;

//Start RabbitMQ Server
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('video_queue', 	//$queue - Either sets the queue or creates it if not exist
						false,			//$passive - Do not modify the servers state
						true,			//$durable - Data will persist if crash or restart occurs
						false,			//$exclusive - Only one connection will usee, and deleted when closed
						false			//$auto_delete - Queue is deleted when consumer is no longer subscribes
						);

/**
 * Define the callback function (qui sera exécutée lorsque des messages sont reçus dans la file d'attente)
 */
$callback = function($msg) {
	//Convert the data to array (Récupère les données JSON du message reçu)
	$data = json_decode($msg->body, true);

	//Detect if wget and ffmpeg are installed
	exec("command -v wget", $wget_exist);
	exec("command -v ffmpeg", $ffmpeg_exist);
	//Si wget est disponible, il utilise wget pour télécharger la vidéo spécifiée dans les données
	if ($wget_exist) {
		//Use wget to download the video.
		exec("wget -O video.mp4 {$data['video_url']}");
	} else {
		//Use ProdigyView's FileManager as backup
		FileManager::copyFileFromUrl($data['video_url'], getcwd() . '/', 'video.mp4');
	}
	//Si ffmpeg est disponible, il utilise ffmpeg pour convertir la vidéo dans le format spécifié
	if ($ffmpeg_exist) {
		//Run a conversion using ffmpeg
		Video::convertVideoFile('video.mp4', 'video.' . $data['convert_to']);
	} else {
		//Si ffmpeg n'est pas disponible, il affiche un message indiquant l'absence de logiciel de conversion sur le serveur
		echo "Sorry No Conversion Software Exist On Server\n";
	}

	echo "Finished Processing\n";
};

//Pass the callback
$channel->basic_consume('video_queue', '', false, false, false, false, $callback);

//Listen to requests
while (count($channel->callbacks)) {
	$channel->wait();
}
