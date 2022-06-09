<?php

//Chat.php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface 
{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo ' Wamglam Server Started';
    }

    public function onOpen(ConnectionInterface $conn) {

        // Store the new connection to send messages to later
        echo ' Wamglam Server Started';
        require('connection.php');
        $this->clients->attach($conn);

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);
       echo"<pre>";
                 print_r($queryarray);
        if(isset($queryarray['token']))
        {
             
                 echo"Pchat";
             $token=$queryarray['token'];
             $roomID=$queryarray['room'];
             $userID=$queryarray['userID'];
            
           
            $connectionID=$conn->resourceId;
            $Selectquery=mysqli_query($con,"select * from UserConnectionTb where token='".$token."'");
            $rows=mysqli_num_rows($Selectquery);
            if($rows>0)
            {
                 mysqli_query($con,"update UserConnectionTb SET connectionID='".$connectionID."' where token='".$token."'");
                
                
            }
            else
            {
                mysqli_query($con,"insert into UserConnectionTb(token,connectionID,status) values('".$token."','".$connectionID."','1')");
               
            }
            
            
            
        
             $RoomSelectquery=mysqli_query($con,"select * from ChatRoomTb where roomID='".$roomID."' AND UserJoinID='".$userID."'");
			 $Roomrows=mysqli_num_rows($RoomSelectquery);
					if($Roomrows>0)
					{
					
						 mysqli_query($con,"update ChatRoomTb SET UserJoinID='".$userID."',status='1' where roomID='".$roomID."' AND UserJoinID='".$userID."'");
						
					}
					else
					{
					
						mysqli_query($con,"insert into ChatRoomTb(roomID,UserJoinID,status,createdDate) values('".$roomID."','".$userID."','1',UTC_TIMESTAMP())");
					}
             
        }

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        $serverKey="AAAAIzmSEps:APA91bF1Agcw1ClZSUZXJHDh7kTNOrtkZS9N4SjodBF406ZiPKFCcK_6UZ0KcFV0SBLMCtKtTo1XVCIuglbF04z05lYlEtGgvlhmDbVpXxVjZyt7LHVRsGskkunf660YbYqwqgGrTamZ";
        require('connection.php');
        $data = json_decode($msg, true);
        echo"<pre>";
        print_r($data);
        $serviceType=$data['serviceType'];
        date_default_timezone_set('UTC');
        
        
         if($serviceType=='RecentChat')
         {
             
               $userID=$data['userID'];
               
               $ChatQuery=mysqli_query($con,"SELECT * FROM 
			(SELECT DISTINCT sender.name as senderName, sender.id as sender_id,sender.email as senderEmail,sender.profile_picture as sender_profile_picture,
            receiver.name as receiverName, receiver.id as receiver_id,receiver.email as recieverEmail,receiver.profile_picture as receiver_profile_picture,
            msg.message,msg.created_on,msg.status as readStatus,msg.MessageType,
			(CASE msg.source_user_id > msg.target_user_id
            WHEN true THEN CONCAT(msg.target_user_id, '|', msg.source_user_id)
            WHEN false THEN CONCAT(msg.source_user_id, '|', msg.target_user_id)
        	END) as hash
			FROM user_chat msg INNER JOIN users sender ON msg.source_user_id = sender.id
            INNER JOIN users receiver ON msg.target_user_id = receiver.id 
			WHERE (msg.source_user_id='".$userID."' OR msg.target_user_id='".$userID."') ORDER BY msg.created_on DESC) as main 
			GROUP BY hash ORDER BY created_on DESC");
			while($ChatData=mysqli_fetch_assoc($ChatQuery))
			{
			     $sender_id=$ChatData['sender_id'];
			     $receiver_id=$ChatData['receiver_id'];
			     
			     if($sender_id==$userID)
			     {
			         $NewID=$receiver_id;
			     }
			     elseif($receiver_id==$userID)
			     {
			          $NewID=$sender_id;
			     }
			     else
			     {
			         
			     }
			     
			     $MsgAddTime=$ChatData['created_on'];
			     $checkDeleteQuery=mysqli_query($con,"select * from chat_deleteTB where deleteByuserID='".$userID."' AND ChatParticipantID='".$NewID."' AND deletedDate>'".$MsgAddTime."'");
			     $checkDeleteRows=mysqli_num_rows($checkDeleteQuery);
			     
			     if($checkDeleteRows>0)
			     {
			         
			     }
			     else
			     {
			     $UnreadQuery=mysqli_query($con,"SELECT id FROM user_chat WHERE source_user_id = '".$NewID."' AND target_user_id = '".$userID."' AND status='0'");
			     $unreadCount=mysqli_num_rows($UnreadQuery);
			     
			     $RecentChatGetUsersTimeQuery= mysqli_query($con,"select createdDate from ChatRoomTb where UserJoinID='".$sender_id."'");
                 $RecentGetUsersTimeData=mysqli_fetch_assoc($RecentChatGetUsersTimeQuery);
                 $RecentUserOfflineTime=$RecentGetUsersTimeData['createdDate'];
                 
                 $RecentChatGetRecieverTimeQuery= mysqli_query($con,"select createdDate from ChatRoomTb where UserJoinID='".$receiver_id."'");
                 $RecentGetRecieverTimeData=mysqli_fetch_assoc($RecentChatGetRecieverTimeQuery);
                 $RecentRecieverOfflineTime=$RecentGetRecieverTimeData['createdDate'];
                 $ChatData['senderOfflineTime']=$RecentUserOfflineTime;
                 $ChatData['recieverOfflineTime']=$RecentRecieverOfflineTime;
                 $ChatData['unreadCount']=$unreadCount;
			    $ChatDatas[]=$ChatData;
			    }
			}
		 
                $Senderquery1=mysqli_query($con,"select token from users where id='".$userID."'");
                $senderDatas=mysqli_fetch_assoc($Senderquery1);
                $SenderDBtoken=$senderDatas['token'];
               
                
                $Senderquery2=mysqli_query($con,"select * from UserConnectionTb where token='".$SenderDBtoken."'");
                $Senderdatas2=mysqli_fetch_assoc($Senderquery2);
                $sender_user_connection_id=$Senderdatas2['connectionID'];
        
                 echo $response=array('Response' => 'true', 'message' => 'Data Found','type' => 'RecentChat','data' => $ChatDatas);
                	foreach ($this->clients as $client) 
			        {
					  if($client->resourceId==$sender_user_connection_id)
					  {
					      echo $client->resourceId."==="; echo $sender_user_connection_id;
					      echo"Yes";
					    $client->send(json_encode($response));
					  }
					  else
					  {
					      echo"Not";
					  }
			        }
         }
       
        // When user Goes Offline
         elseif($serviceType=='Offline')
        {
            	 $userID=$data['user_id'];
            
                mysqli_query($con,"update ChatRoomTb SET createdDate=UTC_TIMESTAMP() where UserJoinID='".$userID."'");
                
                $GetFriendQuery=mysqli_query($con,"select (CASE msg.user_id = '".$userID."'
            WHEN true THEN msg.friend_id
            WHEN false THEN msg.user_id
        	END) as friend_id
	from user_friends msg inner join users sender on msg.user_id = sender.id
					  inner join users receiver on msg.friend_id = receiver.id where (msg.user_id='".$userID."' OR msg.friend_id='".$userID."') AND msg.req_status='2' AND msg.is_unfriend='0'");
                while($GetFriendData=mysqli_fetch_assoc($GetFriendQuery))
                {
                    
                    $friend_id=$GetFriendData['friend_id'];
                    
                    $GetFriendQuery1=mysqli_query($con,"SELECT UserConnectionTb.connectionID,users.profile_image FROM users LEFT JOIN UserConnectionTb ON UserConnectionTb.token=users.token where users.id='".$friend_id."'");
                    $GetFriendData1=mysqli_fetch_assoc($GetFriendQuery1);
                   // $GetFriendConnectionDatas[]=$GetFriendData1['connectionID'];
                    $GetFriendConnectionID=$GetFriendData1['connectionID'];
                    
                    
                    
                     $RecentChatQuery=mysqli_query($con,"SELECT * FROM 
			(SELECT DISTINCT sender.name as senderName, sender.id as sender_id,sender.is_login as senderOnlineStatus, sender.profile_image as sender_profile_picture,
            receiver.name as receiverName, receiver.id as receiver_id,receiver.is_login as recieverOnlineStatus, receiver.profile_image as receiver_profile_picture,
            msg.message,msg.created_on,msg.MessageType,
			(CASE msg.source_user_id > msg.target_user_id
            WHEN true THEN CONCAT(msg.target_user_id, '|', msg.source_user_id)
            WHEN false THEN CONCAT(msg.source_user_id, '|', msg.target_user_id)
        	END) as hash
			FROM user_chat msg INNER JOIN users sender ON msg.source_user_id = sender.id
            INNER JOIN users receiver ON msg.target_user_id = receiver.id 
			WHERE (msg.source_user_id='".$userID."' OR msg.target_user_id='".$userID."') AND (msg.source_user_id='".$friend_id."' OR msg.target_user_id='".$friend_id."') ORDER BY msg.created_on DESC) as main 
			GROUP BY hash ORDER BY created_on DESC");
		    $RecentChatData=mysqli_fetch_assoc($RecentChatQuery);
		   
		    $GetUsersTimeQuery= mysqli_query($con,"select createdDate from ChatRoomTb where UserJoinID='".$userID."'");
            $GetUsersTimeData=mysqli_fetch_assoc($GetUsersTimeQuery);
            $UserOfflineTime=$GetUsersTimeData['createdDate'];
             $RecentChatData['offlineTime']=$UserOfflineTime;
              $response=array('Response' => 'true', 'message' => 'Data Found','type' => 'Offline','data' => $RecentChatData,'offlineTime' => $UserOfflineTime);       
            
               foreach ($this->clients as $client) 
			        {
			           
					  if($client->resourceId==$GetFriendConnectionID)
					  {
					      echo"Yes";
					    $client->send(json_encode($response));
					  }
					  else
					  {
					      echo"Not";
					  }
			        }
               
                }
                
               
        }
       // When user Goes Offline
         elseif($serviceType=='Block')
        {
            	 $userID=$data['user_id'];
            	 $block_user_id=$data['block_user_id'];
            	 
            	
            	  $GetUserQuery1=mysqli_query($con,"SELECT UserConnectionTb.connectionID FROM users LEFT JOIN UserConnectionTb ON UserConnectionTb.token=users.token where users.id='".$block_user_id."'");
                  $GetUserData1=mysqli_fetch_assoc($GetUserQuery1);
                  $GetUserConnectionID=$GetUserData1['connectionID'];
                  
                   $response=array('Response' => 'true', 'message' => 'Data Found','type' => 'Block','BlockedBy' => $userID);
                  foreach ($this->clients as $client) 
			        {
			           
					  if($client->resourceId==$GetUserConnectionID)
					  {
					      echo"Yes";
					    $client->send(json_encode($response));
					  }
					  else
					  {
					      echo"Not";
					  }
			        }
            
                
                
               
        }
        
          elseif($serviceType=='Unblock')
        {
            	 $userID=$data['user_id'];
            	 $unblock_user_id=$data['unblock_user_id'];
            	 
            	
            	  $GetUserQuery1=mysqli_query($con,"SELECT UserConnectionTb.connectionID FROM users LEFT JOIN UserConnectionTb ON UserConnectionTb.token=users.token where users.id='".$unblock_user_id."'");
                  $GetUserData1=mysqli_fetch_assoc($GetUserQuery1);
                  $GetUserConnectionID=$GetUserData1['connectionID'];
                  
                   $response=array('Response' => 'true', 'message' => 'Data Found','type' => 'Unblock','UnblockedBy' => $userID);
                  foreach ($this->clients as $client) 
			        {
			           
					  if($client->resourceId==$GetUserConnectionID)
					  {
					      echo"Yes";
					    $client->send(json_encode($response));
					  }
					  else
					  {
					      echo"Not";
					  }
			        }
            
                
                
               
        }
        
          elseif($serviceType=='ClearChat')
        {
            	 $userID=$data['user_id'];
            	 $other_user_id=$data['other_user_id'];
            	 
            	
            	
            
                 $CheckQuery=mysqli_query($con,"select * from chat_deleteTB where deleteByuserID='".$userID."' AND ChatParticipantID='".$other_user_id."'");
                 $Rows=mysqli_num_rows($CheckQuery);
                 
                 if($Rows>0)
                 {
                     mysqli_query($con,"update chat_deleteTB SET deletedDate=UTC_TIMESTAMP() where deleteByuserID='".$userID."' AND ChatParticipantID='".$other_user_id."'");
                 }
                 else
                 {
                     mysqli_query($con,"insert into chat_deleteTB (deleteByuserID,ChatParticipantID,deletedDate) values('".$userID."','".$other_user_id."',UTC_TIMESTAMP())");
                 }
                 
                 
                   $GetUserQuery1=mysqli_query($con,"SELECT UserConnectionTb.connectionID FROM users LEFT JOIN UserConnectionTb ON UserConnectionTb.token=users.token where users.id='".$userID."'");
                  $GetUserData1=mysqli_fetch_assoc($GetUserQuery1);
                  $GetUserConnectionID=$GetUserData1['connectionID'];
                  
                   $response=array('Response' => 'true', 'message' => 'Data Found','type' => 'clearChat');
                  foreach ($this->clients as $client) 
			        {
			           
					  if($client->resourceId==$GetUserConnectionID)
					  {
					      echo"Yes";
					    $client->send(json_encode($response));
					  }
					  else
					  {
					      echo"Not";
					  }
			        }
                
                
               
        }
        else
        {
        echo"IN Chat";
         // Code for Single One to One Chat
        
        
        $userID=$data['userID'];
		$recieverID=$data['recieverID'];
		$message=$data['msg'];
		$roomID=$data['room'];
        $MessageType=$data['MessageType'];
        
        
       
        $query1=mysqli_query($con,"select * from users where id='".$recieverID."'");
        $datas=mysqli_fetch_assoc($query1);
        $DBtoken=$datas['token'];
        
        $GetDeviceQuery=mysqli_query($con,"select * from user_devices where user_id='".$recieverID."'");
        $GetDevicedatas=mysqli_fetch_assoc($GetDeviceQuery);
        $device_type=$GetDevicedatas['type'];
        $device_token=$GetDevicedatas['token'];
        
        $query2=mysqli_query($con,"select * from UserConnectionTb where token='".$DBtoken."'");
        $datas2=mysqli_fetch_assoc($query2);
        echo"RcConnectionId-"; echo $receiver_user_connection_id=$datas2['connectionID'];
        
        
        
        
        $UserQuery1=mysqli_query($con,"select * from users where id='".$userID."'");
        $Userdatas=mysqli_fetch_assoc($UserQuery1);
        $Userfull_name=$Userdatas['name'];
        $UserEmail=$Userdatas['email'];
        $profile_picture=$Userdatas['profile_picture'];
        $UserTypes=$Userdatas['type'];
       
       
        
        
        foreach($this->clients as $client)
            {
				
               $query3=mysqli_query($con,"select * from ChatRoomTb where roomID='".$roomID."' AND status='1'");
               $Counts=mysqli_num_rows($query3);
               
			   $datas3=mysqli_fetch_assoc($query3);
			   
			   
               
              echo"ResouceID"; echo $client->resourceId;
                if($client->resourceId == $receiver_user_connection_id)
                {  
   
                      echo"When Online";
                     
                    if($Counts==2) 
                    { 
						if($data['type']=='Chat')
						{
						
						
						
						$InsertQuery=mysqli_query($con,"insert into user_chat(roomID,source_user_id,target_user_id,message,status,MessageType,modified_on,created_on) values('".$roomID."','".$userID."',
						'".$recieverID."','".$message."','1','".$MessageType."',UTC_TIMESTAMP(),UTC_TIMESTAMP())");
						 $insertID=mysqli_insert_id($con);
						
						 $GetQuery=mysqli_query($con,"select distinct sender.name as senderName, sender.id as sender_id,sender.profile_picture as sender_profile_picture,
					receiver.name as receiverName, receiver.id as receiver_id, receiver.profile_picture as receiver_profile_picture,
					msg.message,msg.status as readStatus,msg.created_on	,msg.MessageType
	from user_chat msg inner join users sender on msg.source_user_id = sender.id
					  inner join users receiver on msg.target_user_id = receiver.id where msg.id='".$insertID."'");
						 $GetData=mysqli_fetch_assoc($GetQuery);
						 
						 $GetDatas[]=$GetData;
						 
						  $response=array('Response' => 'true', 'message' => 'Data Found1','data' => $GetDatas);
						  
						   echo json_encode($response);
							$client->send(json_encode($response)); 
						}
						elseif($data['type']=='read')
						{
							 mysqli_query($con,"update user_chat SET status='1' where target_user_id='".$userID."' AND source_user_id='".$recieverID."' AND roomID='".$roomID."'");
						}
						else
						{
							
						}
                    
				   }
                    elseif($Counts==1)
                    {
						
						
						if($data['type']=='Chat')
						{
						
						
					 $InsertQuery=mysqli_query($con,"insert into user_chat(roomID,source_user_id,target_user_id,message,status,MessageType,modified_on,created_on) values('".$roomID."','".$userID."',
                    '".$recieverID."','".$message."','0','".$MessageType."',UTC_TIMESTAMP(),UTC_TIMESTAMP())");
                    
						 $insertID=mysqli_insert_id($con);
						
						 $GetQuery=mysqli_query($con,"select distinct sender.name as senderName, sender.id as sender_id,sender.profile_picture as sender_profile_picture,
					receiver.name as receiverName, receiver.id as receiver_id, receiver.profile_picture as receiver_profile_picture,
					msg.message,msg.status as readStatus,msg.created_on,msg.MessageType
	from user_chat msg inner join users sender on msg.source_user_id = sender.id
					  inner join users receiver on msg.target_user_id = receiver.id where msg.id='".$insertID."'");
						 $GetData=mysqli_fetch_assoc($GetQuery);
						 
						 $GetDatas[]=$GetData;
						 
						  $response=array('Response' => 'true', 'message' => 'Data Found2','data' => $GetDatas);
						  
						   echo json_encode($response);
							//$client->send(json_encode($response)); 
						
						
						$ArrayRoom=explode("-",$roomID);
					
					 $RoomUserID=$datas3['UserJoinID'];
						if (($key = array_search($RoomUserID, $ArrayRoom)) !== false) 
						{
						unset($ArrayRoom[$RoomUserID]);
						}
						
					
						$GetReciverID=$ArrayRoom[0];
						
						$GetRecieverQuery1=mysqli_query($con,"select * from users where id='".$GetReciverID."'");
						$GetRecieverdatas=mysqli_fetch_assoc($GetRecieverQuery1);
						
						
						$GetRecieverDeviceQuery1=mysqli_query($con,"select * from user_devices where user_id='".$GetReciverID."'");
						$GetRecieverDevicedatas=mysqli_fetch_assoc($GetRecieverDeviceQuery1);
						
						$GetRecieverDBtoken=$datas['token'];
						 $GetRecieverDevice_type=$GetRecieverDevicedatas['type'];
					    $GetRecieverDevice_token=$GetRecieverDevicedatas['token'];
						
						if($MessageType=='Location')
                        {
                        	$messageJSON=json_decode($message);
                        	$message=$messageJSON->location;
                				
                        }
					
							 if($GetRecieverDevice_type=='android')
							 { 
							
							 	$message1 = array
							(
							'body' 	=> $message,
							'title'	=> $Userfull_name
							);
							$field=array('title' => $Userfull_name,
						'type'=>'message',
                        'message' => $message,
                        'sender_id'=>$userID,
                        'sender_name'=>$Userfull_name,
                        'sender_email'=>$UserEmail,
                        'sender_profile_picture'=> $profile_picture,
                        'UserTypes'=>$UserTypes,
                        'roomID'=>$roomID,
                        'receiver_id'=>$recieverID); 

	
							$fields = array

								(

									'to'		=> $device_token,
									'data'  => $field           

								);
   
							$headers = array

									(

										'Authorization: key=' . $serverKey,

										'Content-Type: application/json'

									);
            
							$ch = curl_init();

							curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );

							curl_setopt( $ch,CURLOPT_POST, true );

							curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );

							curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );

							curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

							curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields) );

							$results=curl_exec($ch );
						
							
							$resultsArray=json_decode($results);
							
						 }
						 else
						 {
							 
							 
							 
							 	$url = "https://fcm.googleapis.com/fcm/send";

					
					$notification=array(
					    'title' => $Userfull_name,
					    'body'  => $message,
						'type'=>'message',
                        'message' => $message,
                         'sender_id'=>$userID,
                         'sender_name'=>$Userfull_name,
                         'sender_email'=>$UserEmail,
                        'sender_profile_picture'=> $profile_picture,
                        'UserTypes'=>$UserTypes,
                          'roomID'=>$roomID,
                        'receiver_id'=>$recieverID,
						'sound' => 'default',
						'badge' => '1'); 		
					
					$arrayToSend = array('to' => $device_token, 'notification' => $notification,'priority'=>'high');
					$json = json_encode($arrayToSend);
					$headers = array();
					$headers[] = 'Content-Type: application/json';
					$headers[] = 'Authorization: key='. $serverKey;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);

					curl_setopt($ch, CURLOPT_CUSTOMREQUEST,

					"POST");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
					$results=curl_exec($ch);
					
					$resultsArray=json_decode($results);
			echo"<pre>";
			print_r($resultsArray);
					$success=$resultsArray->success;
					curl_close($ch);	
	
							 
							 
					}
						
					}    // When type= Chat	
					elseif($data['type']=='read')
						{
							 mysqli_query($con,"update user_chat SET status='1' where target_user_id='".$userID."' AND source_user_id='".$recieverID."' AND roomID='".$roomID."'");
						}
						else
						{
							
						}	
						
					}
					else
					{
						echo"No count";
					}
                   
                   
                }
                else
                {
                    echo"Not REceiver connected";
                }
				
				
			}
			
			if($receiver_user_connection_id==0)
				{
				
					if($data['type']=='Chat')
                    {
						
						echo "insert into user_chat(roomID,source_user_id,target_user_id,message,status,MessageType,modified_on,created_on) values('".$roomID."','".$userID."',
                    '".$recieverID."','".$message."','0','".$MessageType."',UTC_TIMESTAMP(),NOW())";
					 $InsertQuery=mysqli_query($con,"insert into user_chat(roomID,source_user_id,target_user_id,message,status,MessageType,modified_on,created_on) values('".$roomID."','".$userID."',
                    '".$recieverID."','".$message."','0','".$MessageType."',UTC_TIMESTAMP(),UTC_TIMESTAMP())");
                    
                    
                   
							 if($MessageType=='Location')
                        {
                        	$messageJSON=json_decode($message);
                        	$message=$messageJSON->location;
                				
                        }
                        
							 if($device_type=='android')
							 { 
							
							 	$message1 = array
							(
							'body' 	=> $message,
							'title'	=> $Userfull_name
							);
							$field=array('title' => $Userfull_name,
						'type'=>'message',
                        'message' => $message,
                        'sender_id'=>$userID,
                        'sender_name'=>$Userfull_name,
                        'sender_email'=>$UserEmail,
                        'sender_profile_picture'=> $profile_picture,
                        'UserTypes'=>$UserTypes,
                         'roomID'=>$roomID,
                        'receiver_id'=>$recieverID); 

	
							$fields = array

								(

									'to'		=> $device_token,
									'data'  => $field           

								);
   
							$headers = array

									(

										'Authorization: key=' . $serverKey,

										'Content-Type: application/json'

									);
            
							$ch = curl_init();

							curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );

							curl_setopt( $ch,CURLOPT_POST, true );

							curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );

							curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );

							curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

							curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields) );

							$results=curl_exec($ch );
						
							
							$resultsArray=json_decode($results);
							
						 }
						 else
						 {
							 
							 
							 
							 	$url = "https://fcm.googleapis.com/fcm/send";

					
					$notification=array(
					   'title' => $Userfull_name,
					    'body'  => $message,
						'type'=>'message',
                        'message' => $message,
                         'sender_id'=>$userID,
                         'sender_name'=>$Userfull_name,
                         'sender_email'=>$UserEmail,
                        'sender_profile_picture'=> $profile_picture,
                        'UserTypes'=>$UserTypes,
                          'roomID'=>$roomID,
                        'receiver_id'=>$recieverID,
						'sound' => 'default',
						'badge' => '1'); 		
					
					$arrayToSend = array('to' => $device_token, 'notification' => $notification,'priority'=>'high');
					$json = json_encode($arrayToSend);
					$headers = array();
					$headers[] = 'Content-Type: application/json';
					$headers[] = 'Authorization: key='. $serverKey;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);

					curl_setopt($ch, CURLOPT_CUSTOMREQUEST,

					"POST");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
					$results=curl_exec($ch);
					
					$resultsArray=json_decode($results);
			
					$success=$resultsArray->success;
					curl_close($ch);	
	
							 
							 
					}
				}
				
					elseif($data['type']=='read')
                    {
						 mysqli_query($con,"update user_chat SET status='1' where target_user_id='".$userID."' AND source_user_id='".$recieverID."' AND roomID='".$roomID."'");
					}
					
				
                    else
                    {
                        
                    }
			    }
			    else
			    {
			        echo"Reciever ID nOT 0";
			    }
        
        
        
        
        
        }      // End One to one Chat
    }

    public function onClose(ConnectionInterface $conn) {

        require('connection.php');
        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        if(isset($queryarray['token']))
        {
               	$token=$queryarray['token'];
        			$roomID=$queryarray['room'];
                    $userID=$queryarray['userID'];
                    
                    
                    $connectionID=$conn->resourceId;
                    $Selectquery=mysqli_query($con,"select * from UserConnectionTb where token='".$token."'");
                    $rows=mysqli_num_rows($Selectquery);
                    if($rows>0)
                    {
                       
                         mysqli_query($con,"update UserConnectionTb SET connectionID='0' where token='".$token."'");
                         mysqli_query($con,"update ChatRoomTb SET status='0' where roomID='".$roomID."' AND UserJoinID='".$userID."'");
                        
                        
                    }
            
           
        }
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

?>