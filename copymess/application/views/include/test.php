<?php
session_start();

include_once("./includes/global_pgsql.inc");
include_once("./includes/global_php.inc");

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$db = new cDatabase();

//////////////////////////////////inserting values into comment_master for each mixtapes
if (isset($_REQUEST['Send'])) {


    $this_ip1 = $_SERVER['REMOTE_ADDR'];

    $db->beginTransaction();

    $db->query = "select * from banned_ip";
    $db->runQuery();
    $bannediparry1 = $db->returnArrays();

    for ($l = 0; $l < count($bannediparry1); $l++) {
        $baned_ip1 = $bannediparry1[$l]['ip_address'];

        if ($baned_ip1 == $this_ip1) {

            header("location:free_download_chat.php?act1=bannedip&album_id=" . $_REQUEST['album_id'] . "");
            exit;
        } else {

        }
    }
    ////////////////////////filtering the posted comments
    $db->beginTransaction();
    $db->query = "select keyword_content from keywords where keyword_status=1";
    $db->runQuery();
    $keyArray1 = $db->returnArrays();
    $searchword1 = trim($_POST['chat_message']);
    $searcharray1 = explode(" ", strtoupper($_POST['chat_message']));
    ////////////////////////////
    foreach ($searcharray1 as $sk1 => $sv1) {

        if (strlen($sv1) > 250) {
            header("location:free_download_chat.php?act1=greater&album_id=" . $_REQUEST['album_id'] . "");
            exit;
        }
    }
    ///////////////////
    //$searchword=str_replace(" ","",$searchword);
    //$searchword=strtoupper($searchword);
    //$maintext=explode(" ",$$searchword);

    $kkword1 = "";
    for ($j = 0; $j < sizeof($keyArray1); $j++) {
        if ($kkword1 != "") {


            $kkword1 = $kkword1 . "," . $keyArray1[$j]['keyword_content'];
        } else {
            $kkword1 = $keyArray1[$j]['keyword_content'];
        }
    }
    //$kkword=implode(",",$keyArray);
    $kkword1 = strtoupper($kkword1);


    $keyArray2 = explode(",", $kkword1);

    foreach ($keyArray2 as $k => $v) {
        $word = $v;


        if (in_array($word, $searcharray1)) {
            header("location:free_download_chat.php?act1=keywordban&album_id=" . $_REQUEST['album_id'] . "");
            exit;
        } else {

        }
    }

    if (!$_SESSION["member_name"]) {
        $chat_details["chat_login_name"] = $_REQUEST["chat_login_name"];
        $messengername = $_REQUEST["chat_login_name"];
    } else {
        $chat_details["chat_login_name"] = $_SESSION["member_name"];
        $messengername = $_SESSION["member_name"];
    }
    if (($messengername != "Name" && $_REQUEST["chat_message"] != "Message") && ($messengername != "" && $_REQUEST["chat_message"] != "")) {
        $err = "";
        $chat_details["album_id"] = $_REQUEST["album_id"];
        $chat_details["chat_message"] = $_REQUEST["chat_message"];
        $chat_details["chat_ip"] = $_SERVER['REMOTE_ADDR'];
        $chat_details['chat_date'] = time();
        $db->beginTransaction();
        $db->generateInsertQuery("chat", $chat_details);
        $db->runQuery();
        $db->endTransaction();
    } else {
        $err = "Please enter the name and message";
    }
}



////////////////Login Section ////////////////////////////////////////

if ($_REQUEST['logusername'] != "" && $_REQUEST['logpaswd'] != "" && $_REQUEST['login'] == 'Login') {

    $db->generateSelectQuery("member", "", array("member_name" => $_POST["logusername"], "member_password" => $_POST["logpaswd"], "member_Active" => 1));
    $db->runQuery();
    $login_array = $db->returnArrays();
    $db->endTransaction();
    if (!$login_array) {

    } else {

        $member_details["member_ip"] = $REMOTE_ADDR;
        $member_logdetails["log_username"] = $_POST["username"];
        $member_logdetails["log_ipaddress"] = $REMOTE_ADDR;
        $member_logdetails["log_time"] = date("Y-m-d H:i:s");
        $db->beginTransaction();
        $condition["member_id"] = $login_array[0]["member_id"];
        $db->generateUpdateQuery("member", $member_details, $condition);
        $db->runQuery();
        $db->generateInsertQuery("log_master", $member_logdetails);

        $db->runQuery();
        $db->endTransaction();
        $_SESSION["member_name"] = $login_array[0]["member_name"];
    }
}
if (isset($_REQUEST['rateit_x'])) {
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $album_id = $_REQUEST['album_id'];
    $myrate = (int) $_POST['rate_score'];
    if (isset($_SESSION['ipaddress']) and isset($_SESSION['albid'])) {
        if ($_SESSION['ipaddress'] == $ipaddress and in_array($album_id, $_SESSION['albid'])) {
            $ratemessage = "You may only vote once.";
        } else {
            $_SESSION['ipaddress'] = $ipaddress;

            if (is_array($_SESSION['albid'])) {
                $_SESSION['albid'] = array_merge($_SESSION['albid'], array($album_id));
            } else {
                $_SESSION['albid'] = array($album_id);
            }
            mysql_query("update album set album_totalscore=album_totalscore+$myrate,album_totalvote=album_totalvote+1 where album_id='$album_id'");
            $ratemessage = "Your vote has been submitted successfully.";
        }
    } else {

        $_SESSION['ipaddress'] = $ipaddress;

        if (is_array($_SESSION['albid'])) {
            $_SESSION['albid'] = array_merge($_SESSION['albid'], array($album_id));
        } else {
            $_SESSION['albid'] = array($album_id);
        }


        mysql_query("update album set album_totalscore=album_totalscore+$myrate,album_totalvote=album_totalvote+1 where album_id='$album_id'");
        $ratemessage = "Your vote has been submitted successfully.";
    }
}
if (isset($_REQUEST['addcomment_x'])) {

    $this_ip = $_SERVER['REMOTE_ADDR'];

    $db->beginTransaction();
    $db->query = "select * from banned_ip";
    $db->runQuery();
    $bannediparry = $db->returnArrays();

    for ($l = 0; $l < count($bannediparry); $l++) {
        $baned_ip = $bannediparry[$l]['ip_address'];

        if ($baned_ip == $this_ip) {

            header("location:free_download.php?comments=" . urlencode($_POST['comments']) . "&album_id=" . $_REQUEST['album_id'] . "&email=" . $_POST['email'] . "&name=" . $_REQUEST['name'] . "&act=banned");
            exit;
        } else {

        }
    }
    ////////////////////////filtering the posted comments
    $db->beginTransaction();
    $db->query = "select keyword_content from keywords where keyword_status=1";
    $db->runQuery();
    $keyArray = $db->returnArrays();
    $searchword = trim($_POST['comments']);
    $searcharray = explode(" ", strtoupper($_POST['comments']));
    ////////////////////////////
    foreach ($searcharray as $sk => $sv) {
        if (strlen($sv) > 25) {
            header("location:free_download.php?comments=" . urlencode($_POST['comments']) . "&album_id=" . $_REQUEST['album_id'] . "&email=" . $_POST['email'] . "&name=" . $_REQUEST['name'] . "");
            exit;
        }
    }
    ///////////////////
    //$searchword=str_replace(" ","",$searchword);
    //$searchword=strtoupper($searchword);
    //$maintext=explode(" ",$$searchword);
    $kkword = "";
    for ($j = 0; $j < sizeof($keyArray); $j++) {
        if ($kkword != "") {


            $kkword = $kkword . "," . $keyArray[$j]['keyword_content'];
        } else {
            $kkword = $keyArray[$j]['keyword_content'];
        }
    }
    //$kkword=implode(",",$keyArray);
    $kkword = strtoupper($kkword);


    $keyArray1 = explode(",", $kkword);

    foreach ($keyArray1 as $k => $v) {
        $word = $v;
        //$word=str_replace(" ","",$word);
        //$cnt=substr_count($searchword,$word);
        //$word1=$word." ";
        //$word2=" ".$word;
        //if (preg_match("/^\s*$word\s+(.*)/i", $searchword, $matches))

        if (in_array($word, $searcharray)) {
            //if($cnt==0)
            //if(strpos($searchword,$word1)===false and strpos($searchword,$word2)===false)
            header("location:free_download.php?comments=" . urlencode($_POST['comments']) . "&album_id=" . $_REQUEST['album_id'] . "&email=" . $_POST['email'] . "&name=" . $_REQUEST['name'] . "&nb=" . $cnt);
            exit;
        } else {

        }
    }

    $comment_details['comment_name'] = $_POST['name'];
    $comment_details['comment_email'] = "";
    $comment_details['comment_status'] = 1;
    $comment_details['comment_content'] = $_POST['comments'];
    $comment_details['comment_date'] = time();
    $comment_details['comment_album_id'] = $_REQUEST['album_id'];
    $comment_details['comment_ip'] = $this_ip;
    $db->beginTransaction();
    $db->generateInsertQuery("comment_master", $comment_details);
    $db->runQuery();
    $db->endTransaction();
    $msg = "....Your Comments have been Posted Successfully...";
    $msg = base64_encode($msg);
    header("location:free_download.php?commentmsg=" . $msg . "&album_id=" . $_REQUEST['album_id']);
    exit();
}
/////////////////////////////////
// Click on the free download button

if ($_REQUEST['numbercheck'] != "") {
    //echo 'I am here'; exit;

    $numcheck = $_REQUEST['numbercheck'];
}

if ($_REQUEST['msgvar'] != "") {
    $msgvar = $_REQUEST['msgvar'];
}

if ($_REQUEST['tct'] != "") {
    $timecount = $_REQUEST['tct'];
}

if ($_REQUEST['vid'] != "") {
    $vid = $_REQUEST['vid'];
}

$id = $_REQUEST[album_id];
$countQry = "select * from settings";
$result = mysql_query($countQry);
$resultrow = mysql_fetch_array($result);
$maxusers = $resultrow['max_user_download'];
$min_download_interval = $resultrow['min_download_interval'];
$ip = $_SERVER['REMOTE_ADDR'];

if (isset($_REQUEST['submit_x'])) {
    $ip_existQry = "select (" . time() . "-time_download) as myinterval from time_master where ip_address='$ip' order by time_download desc Limit 0,1";
    $ip_Result = mysql_query($ip_existQry);
    $ip_Result_row = mysql_fetch_array($ip_Result);
    $ip_count = mysql_num_rows($ip_Result);

    //check code
    // check concurrent user
    // check last download (single query)
    //after downlaod enter download information
    ///////////////////////////////

    if ($numcheck == $_POST['number']) {
        $m_sql = "select total_users from settings";
        $totResult = mysql_query($m_sql);
        $totuser = mysql_fetch_array($totResult);
        $totalusers = (int) $totuser['total_users'];

        //$time=time();

        /* insert query - if downloading first time */
        //$rocky_query="insert into time_master set time_download=$time, ip_address=$ip, album_id=$id"
        if ($maxusers > $totalusers) { // allowed user per-download
            if ($ip_count == 0) {

                header("location:downloadfree.php?id=$id");
            } else {

                if ($ip_Result_row['myinterval'] >= $min_download_interval) {

                    header("location:downloadfree.php?id=$id");
                } else { // check timeinterval
                    $time_remaining = $min_download_interval - $ip_Result_row['myinterval'];
                    $remaining_time = gmdate('H:i:s', $time_remaining);

                    list($remaining_time_hour, $remaining_time_min, $remaining_time_sec) = explode(':', $remaining_time);


                    $timecount = 1;
                    $is_remaining_time = 1;

                    $_SESSION['r_hour'] = $remaining_time_hour;
                    $_SESSION['r_min'] = $remaining_time_min;
                    $_SESSION['r_sec'] = $remaining_time_sec;

                    #header("location:free_download.php?album_id=$id&tct=$timecount");
                    // header("location: downloadmixtape.php?album_id=$id&tct=$timecount"); // change this

                    $var = $_SERVER['REQUEST_URI'];

                    header("location: $var");
                }
            } //if$ipcount
        } else {
            $msgvar = 2;
            #header("location:free_download.php?album_id=$id&msgvar=$msgvar");
            // header("location: downloadmixtape.php?album_id=$id&msgvar=$msgvar"); // change this
            $var = $_SERVER['REQUEST_URI'];
            header("location: $var");
        }
    } else {
        $vid = 1;
        #header("location:free_download.php?album_id=$id&vid=$vid");
        // header("location: downloadmixtape.php?album_id=$id&vid=$vid"); // change this
        $var = $_SERVER['REQUEST_URI'];
        header("location: $var");
    }
}
?>

<?php
// HTML5 Player
// With Albums

$db->beginTransaction();
$db->query = "UPDATE album SET download_count=download_count+1 WHERE album_id='{$_REQUEST[album_id]}'";
$db->runQuery();

$db->query = "SELECT a.album_id, md.music_director_name FROM music_director md, album a WHERE md.music_director_id = a.music_director_id";
$db->runQuery();
$music_director_array = $db->returnArrays();
$music_director_array2 = Array();
foreach ($music_director_array as $item) {
    $music_director_array2[$item['album_id']] = $item['music_director_name'];
}


$db->query = "SELECT md.music_director_name,
                         a.album_id, a.flamplayer_block, a.album_thumbnail, a.custom_album_url,
                         a.album_title, a.album_found, a.album_downimage,
                         a.album_downrearimage, a.album_url, a.playlist_selected_color,
                         a.player_top_bg, a.player_middle_bg, a.player_playlist_holder_bg,
                         c.category_image_small, a.album_sharedlink, a.album_embededlink,
                         a.album_totalscore, a.album_totalvote, a.album_2,
                         ps.button_url, a.download_count
                         FROM music_director md, album a, category c, player_settings ps
                         WHERE md.music_director_id = a.music_director_id AND a.category_id = c.category_id AND a.album_homeflag = 1 AND
                         a.player_button_color = ps.id AND a.album_id = '{$_REQUEST[album_id]}';";


$db->runQuery();
$music_array = $db->returnArrays();

if ($music_array['0']["album_2"] == 0) {
    $flname = str_replace(".thumb.gif", ".jpg", $music_array[0]["album_downimage"]);
    $img_src = "./members/images/" . $music_array[0]["album_downimage"];
    $imgsrc = "https://www.buymixtapes.com/upload/members/images/" . $flname;
    $imgsrc_soc = "http://www.buymixtapes.com/upload/members/images/" . $flname;
} else if ($music_array['0']["album_2"] == 1) {
    $flname = str_replace(".thumb.gif", ".jpg", $music_array[0]["album_downimage"]);
    $img_src = "./upload/members/images/" . $music_array[0]["album_downimage"];
    $imgsrc = "https://www.buymixtapes.com/upload/members/images/" . $flname;
    $imgsrc_soc = "http://www.buymixtapes.com/upload/members/images/" . $flname;
}

$title = "";
$desc = "";
$descfb = "";
$desctail = "";

if (isset($_REQUEST['album_id']) && $_REQUEST['album_id'] != "") {
    $query1 = "SELECT * FROM album where album_id='" . $_REQUEST['album_id'] . "'";
    $result1 = mysql_query($query1);
    $row1 = mysql_fetch_array($result1);

    $query2 = "select * from music_director where music_director_id='" . $row1['music_director_id'] . "'";
    $result2 = mysql_query($query2);
    $row2 = mysql_fetch_array($result2);

    $title .= "-=#Mixtape=- .::" . $row2['music_director_name'];
    $title .= "-" . $row1['album_title'];
    $desc = $title . "::. <Play/Download>";
    $director_twitter = "";
    $album_twitter = "";
    $director_twitter_count = 0;
    if (isset($row2['music_director_twitter'])) {
        $director_twit_array = split(",", $row2['music_director_twitter']);
        foreach ($director_twit_array as $director_twit_cur) {
            if (strlen($director_twit_cur) > 2) {
                $director_twitter .= " @" . str_replace(" ", "", $director_twit_cur) . "";
                $director_twitter_count++;
            }
        }
    }

    if (isset($row1['album_twitter'])) {
        $album_twit_array = split(",", $row1['album_twitter']);
        foreach ($album_twit_array as $album_twit_cur) {
            if (strlen($album_twit_cur) > 2) {
                if ($director_twitter_count < 2) {
                    $album_twitter .= " @" . str_replace(" ", "", $album_twit_cur) . "";
                }
                $director_twitter_count++;
            }
        }
    }

    $title .= " | Buymixtapes.com";

    $titlefb = $row2['music_director_name'];
    $titlefb .= " - " . $row1['album_title'];
    $descfb = $titlefb . " | ";
    $desctail = " | Stream and download this mixtape free";
    $titlefb .= " | Buymixtapes.com";

    $link_url = "/" . str_replace(" ", "-", $row2["music_director_name"]) . "-" . str_replace(" ", "-", $row1["album_title"]) . "." . $row1["album_id"] . ".mixtape";
    include_once "redirections.php";
    url_should_be($link_url);





}
?>
<?php
// check time interval
//  $ip                    = $_SERVER['REMOTE_ADDR'];
//
//  $ip_existQry   = "select (".time()."-time_download) as myinterval from time_master where ip_address='$ip' order by time_download desc Limit 0,1";
//  $ip_Result     = mysql_query($ip_existQry);
//  $ip_Result_row = mysql_fetch_array($ip_Result);
//  $ip_count      = mysql_num_rows($ip_Result);
//
//  $time_remaining = $min_download_interval - $ip_Result_row['myinterval'];
//  $remaining_time = gmdate('H:i:s', $time_remaining);
//
//  list($remaining_time_hour, $remaining_time_min, $remaining_time_sec) = explode(':', $remaining_time);
//
//
//  $timecount = 1;
//  $_SESSION['r_hour']    = $remaining_time_hour;
//  $_SESSION['r_min']     = $remaining_time_min;
//  $_SESSION['r_sec']     = $remaining_time_sec;
?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"  xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://developers.facebook.com/schema/">
<head>
    <meta name="theme-color" content="#3085d8">
    <meta name="keywords" content="download free mixtapes">
    <link rel="shortcut icon" type="image/x-icon" href="http://buymixtapes.com/favicon.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html">
    <title>
        <?php
        //echo "The Game America";
        if (isset($_REQUEST['album_id']) && $_REQUEST['album_id'] != "") {
            $query1 = "select * from album where album_id='" . $_REQUEST['album_id'] . "'";
            $result1 = mysql_query($query1);
            $row1 = mysql_fetch_array($result1);

            $query2 = "select * from music_director where music_director_id='" . $row1['music_director_id'] . "'";
            $result2 = mysql_query($query2);
            $row2 = mysql_fetch_array($result2);

            /* echo $row2['music_director_name'];
              echo " - ".$row1['album_title'];
              echo " | Buymixtapes.com "; */
            $tt = $row2['music_director_name'] . " - " . $row1['album_title'] . " | Buymixtapes.com ";
        }
        echo $tt;

        if ($title == '') {
            $title = $tt; //$row2['music_director_name']. " ".$row1['album_title']. " ".$_REQUEST['album_id']	;
        }
        if ($desc == '') {
            $desc = "Listen or download this mixtape free"; //$row2['music_director_name']. " ".$row1['album_title'];
        }
        ?>
    </title>
    <!--[if gte IE 9]>
    <link href="/_deploy/css/html5audio-new_iecss_edge.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/css/style_amit_edge3.css" type="text/css">
    <link href="/includes/mystyle.css" rel="stylesheet" type="text/css">
    <link href="/includes/style.css" rel="stylesheet" type="text/css">
    <link href="css/responsive_big5.css" rel="stylesheet" type="text/css">
    <link href="css/mobile-menu-info.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/_deploy/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="script/mobile-menu.js"></script>

    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />

    <?php

    function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    ?>

    <?
    /* $db->beginTransaction();
      $db->query="select a.album_has_html_block_code, a.album_html_block_code, a.album_has_official_tag, md.music_director_name, a.custom_album_url, a.playlist_selected_color, a.player_top_bg, a.player_middle_bg, a.player_playlist_holder_bg, a.album_id, a.flamplayer_block,a.album_thumbnail,a.album_title,a.album_found,a.album_downimage,a.album_downrearimage,a.album_url,c.category_image_small,a.album_sharedlink,a.album_embededlink,a.album_totalscore,a.album_totalvote,a.album_2, ps.button_url FROM music_director md, album a, category c, player_settings ps WHERE md.music_director_id=a.music_director_id and a.category_id=c.category_id and a.album_homeflag=1 AND a.player_button_color = ps.id AND a.album_id='{$_REQUEST[album_id]}';";
      $db->runQuery();
      $music_array=$db->returnArrays();
      $db->query="select * from settings";
      $db->runQuery();
      $settings=$db->returnArrays();
      $db->endTransaction(); */
    $db->beginTransaction();
    $db->query = "select a.album_has_html_block_code, a.album_html_block_code, a.album_has_official_tag, md.music_director_name, md.music_director_twitter, a.custom_album_url, a.playlist_selected_color, a.player_top_bg, a.player_middle_bg, a.player_playlist_holder_bg, a.album_id, a.album_twitter, a.flamplayer_block,a.album_thumbnail,a.album_title,a.album_found,a.album_downimage,a.album_downrearimage,a.album_url,c.category_image_small,a.album_sharedlink,a.album_embededlink,a.album_totalscore,a.album_totalvote,a.album_2, ps.button_url FROM music_director md, album a, category c, player_settings ps WHERE md.music_director_id=a.music_director_id and a.category_id=c.category_id and a.album_homeflag=1 AND a.player_button_color = ps.id AND a.album_id='{$_GET[album_id]}';";
    $db->runQuery();
    $music_array = $db->returnArrays();
    ?>
    <meta name="title" content="<?= $titlefb ?>" />
    <meta name="robots" content="index,follow">
    <!--<meta name="viewport" content="width=1000">-->
    <meta name="description" content="<?= $descfb ?><?php if ($music_array['0']['album_has_html_block_code'] == '1'): ?>
       <?php echo html_entity_decode(stripslashes($music_array['0']['album_html_block_code'])); ?>
 <?php else: ?>
       <?php
        include_once 'description_creator.php';
        echo $customDescription;
        ?>
 <?php endif; ?><?= $desctail ?>">
    <meta itemprop="description" content="<?= $descfb ?><?php if ($music_array['0']['album_has_html_block_code'] == '1'): ?>
       <?php echo html_entity_decode(stripslashes($music_array['0']['album_html_block_code'])); ?>
 <?php else: ?>
       <?php
        include_once 'description_creator.php';
        echo $customDescription;
        ?>
 <?php endif; ?><?= $desctail ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9">
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="<?= $titlefb ?>" />
    <meta property="og:url" content="http://www.buymixtapes.com<?=$link_url?>" />
    <meta property="og:image" content="<?= $imgsrc_soc ?>" />
    <meta property="og:site_name" content="Buymixtapes.com"/>
    <meta property="og:description" content="<?= $descfb ?><?php if ($music_array['0']['album_has_html_block_code'] == '1'): ?>
       <?php echo html_entity_decode(stripslashes($music_array['0']['album_html_block_code'])); ?>
 <?php else: ?>
       <?php
        include_once 'description_creator.php';
        echo $customDescription;
        ?>
 <?php endif; ?><?= $desctail ?>">
    <meta property="fb:admins" content="100000133107100"/>
    <meta property="fb:app_id" content="126223704088492"/>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $titlefb ?>" />
    <meta name="twitter:domain" content="buymixtapes"/>
    <meta name="twitter:description" content="<?php if ($music_array['0']['album_has_html_block_code'] == '1'): ?>
		       <?php echo html_entity_decode(stripslashes($music_array['0']['album_html_block_code'])); ?>
		 <?php else: ?>
		       <?php
        include_once 'description_creator.php';
        echo $customDescription;
        ?>
		 <?php endif; ?><?= $desctail ?>">
    <meta name="twitter:image:src" content="<?= $imgsrc_soc ?>" />


    <script language="JavaScript" type="text/JavaScript">




        function MM_preloadImages()
        {
            var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
            var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
                if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
        }

        function MM_swapImgRestore()
        {
            var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
        }

        function MM_findObj(n, d)
        {
            var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
            if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
            for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
            if(!x && d.getElementById) x=d.getElementById(n); return x;
        }

        function MM_swapImage() {
            var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length2);i+=3)
                if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
        }
        function displayForm()
        {
            document.getElementById("display_log").style.display='inline';
            document.getElementById("display_plus").style.display='none';
            document.getElementById("display_minus").style.display='inline';
        }
        function disphid()
        {
            document.getElementById("display_log").style.display='none';
            document.getElementById("display_plus").style.display='inline';
            document.getElementById("display_minus").style.display='none';
        }


    </script>
    <script type="text/javascript" src="/_deploy/js/jquery-1.9.1.min.js"></script>

    <!--<script type="text/javascript" src="http://www.buymixtapes.com/js/jquery.countdown.js"></script>-->
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var liftoffTime = new Date();
            liftoffTime.setDate(liftoffTime.getDate() + 5);

            /*
             jQuery("#defaultCountdown").countdown({
             until: '+<?php echo $_SESSION['r_hour']; ?>h +<?php echo $_SESSION['r_min']; ?>m +<?php echo $_SESSION['r_sec']; ?>s',
             layout: 'Only <b>{hnn}{sep}{mnn}{sep}{snn}</b> until your next free download'
             });
             */
        });

        //$(function() {
        //
        //  //var newYear = new Date();
        //
        //  //newYear = new Date(newYear.getFullYear() + 1, 1 - 1, 1);
        //
        //  var liftoffTime = new Date();
        //  liftoffTime.setDate(liftoffTime.getDate() + 5);
        //
        //  $("#defaultCountdown").countdown({
        //    until: '+<?php echo $_SESSION['r_hour']; ?>h +<?php echo $_SESSION['r_min']; ?>m +<?php echo $_SESSION['r_sec']; ?>s',
        //    layout: 'Only <b>{hnn}{sep}{mnn}{sep}{snn}</b> until your next free download'
        //  });
        //
        ////  $('#removeCountdown').toggle(function() {
        ////          $(this).text('Re-attach');
        ////          $('#defaultCountdown').countdown('destroy');
        ////      },
        ////      function() {
        ////          $(this).text('Remove');
        ////          $('#defaultCountdown').countdown({until: newYear});
        ////      }
        ////  );
        //});
    </script>
    <script>
        $(document).ready(function()
        {
            $('#submitbutton').click(function(e)
            {
                var accesscode = $('#checknumberblank').val();
                if(accesscode === '')
                {
                    alert("Please enter access code.");
                    return false;
                }
                else
                {
                    var validaccesscode = $('#numbercheck').val();
                    if(accesscode === validaccesscode)
                    {
                        // check download time
                        var albumid = $('#albummainid').val();
                        $.ajax({
                            type: "POST",
                            url: 'checkuserdownloadtime.php',
                            dataType: "json",
                            data: {album_id : albumid},
                            async:false,
                            success: function(data) {
                                if(data['log'] == 'false')
                                {
                                    //alert("Minimum wait time required between FREE downloads has not been reached.  Please try again after 15 minutes from the start of your free download.\n\nJoin Now and create your Premium Membership for no wait!");
                                    var msgContent="<br/>"+
                                        "Minimum wait time required between FREE downloads has not been reached.  "+
                                        "Please try again after 15 minutes from the completion of your free download.<br/><br/>"+
                                        "<span>Create your Premium Membership for no wait!</span><br/>"+
                                        "<a href='http://www.buymixtapes.com/join.php'><img src='images/joinnow_msg5.png' alt='Join now for premium access' width='100' height='28' border='0' title='Become a premium member today for no limits!' /></a></td>";
                                    $("#msg_tr").html(msgContent);
                                    e.preventDefault();
                                    return false;
                                }
                                else if(data['log'] == 'limit')
                                {
                                    //alert("All FREE Download Slots are Currently FULL.\n\nPremium members have unlimited download slots.\nJoin Now and create Your Premium Membership Now For No Wait!");
                                    var msgContent="<br/>"+
                                        "All FREE Download Slots are Currently FULL.<br/><br/>"+
                                        "Premium members have unlimited download slots.<br/>"+
                                        "<span>Create your Premium Membership for no wait!</span><br/>"+
                                        "<a href='http://www.buymixtapes.com/join.php'><img src='images/joinnow_msg5.png' alt='Join now for premium access' width='100' height='28' border='0' title='Become a premium member today for no limits!' /></a></td>";
                                    $("#msg_tr").html(msgContent);
                                    e.preventDefault();
                                    return false;
                                }
                                else
                                {
                                    return true;
                                }
                            },
                            error: function(error) {
                                return false;
                            }
                        });



                        // end
                    }
                    else
                    {
                        alert("Invalid access code. Please try again.");
                        return false;
                    }
                }
            });

        });
    </script>
    <script language="JavaScript" type="text/JavaScript">

        function MM_reloadPage(init) {
            if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
                document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
            else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
        }
        MM_reloadPage(true);

        function checkme21()
        {
            var proceed=false;
            for(j=0;j<document.download.rate_score.length;j++)
            {
                if(document.download.rate_score[j].checked==true)
                {
                    proceed=true;
                    break;

                }

            }
            if(proceed==false)
            {
                alert("Please choose your rating");
                return false;

            }
            else
            {
                return true;

            }

        }
        function checkcomment()
        {


            if(document.form1.comments.value=="")
            {
                alert("Enter Your  Comments");
                document.form1.comments.focus();
                return false;

            }
            if(document.form1.name.value=="")
            {
                alert("Enter Your Name");
                document.form1.name.focus();
                return false;

            }


            return true;

        }
        function ClipBoard(holdtext,copytext)
        {
            holdtext.innerText = copytext.innerText;
            Copied = holdtext.createTextRange();
            Copied.execCommand("RemoveFormat");
            Copied.execCommand("Copy");
            alert("Data copied to your clipboard");
            return false;
        }
    </script>

    <link rel="shortcut icon" type="image/x-icon" href="http://buymixtapes.com/favicon.ico">
    <style type="text/css">
        .bottom_menu ul li {
            display: inline-block;
        }
        .mobile_downloadfree_msg {
            display: none;
        }
        @media screen and (-webkit-min-device-pixel-ratio:0)
        {	.bottom_menu ul li {
            display: inline-table;
            float:left;
        }
        }
    </style>
    <script>
        $(document).ready(function(){
            $("span.menu_trigger").click(function(){
                $('div.navbar_responsive').slideToggle();
            });
            $("a.dropdown-toggle").click(function(){
                $(this).parent().children("ul.dropdown-menu").toggle();
            });
        });
    </script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="bg" onLoad="MM_preloadImages('./images/index_06_over.gif','./images/index_07_over.gif','./images/index_10a_over.gif','./images/index_09_over.gif','./images/index_08_over.gif','./images/m3a_over.gif','./images/m1_over.gif','./images/m2_over.gif','./images/m3_over.gif','./images/m4_over.gif','./images/mf_over.gif','./images/m5_over.gif')">
<?php include_once("analyticstracking.php") ?>
<iframe style="display:none" src="https://developers.facebook.com/tools/debug/og/object?q=<?= urlencode($actual_link); ?>">

</iframe>

<div itemscope itemtype="http://schema.org/Product" class="container main-body">
		<span itemprop="brand" itemscope itemtype="http://schema.org/Brand">
		<meta itemprop="name" content="Buymixtapes.com">
		<meta itemprop="logo" content="http://www.buymixtapes.com/richsnippets_logo.gif"></span>
    <meta itemprop="url" content="http://www.buymixtapes.com<?php echo $link_url; ?>">


    <div class="header">
        <div class="header-content">

        </div>
    </div>

    <? include "includes/mobile-menu.php"; ?>

    <div class="page" style="padding-bottom:0px!important">

        <div class="page-header">

        </div>

        <div class="page-content">
            <div class="page-left">
                <div class="navbar">
                    <ul>
                        <li class="link_home"><a href="home.php" ></a></li>
                        <li class="link_tour"><a href="featured.php"></a></li>
                        <!--join now and accinfo start-->
                        <?php
                        if (empty($_SESSION['member_name'])) {
                            ?>
                            <li class="link_join"><a href="join.php"></a></li>
                            <?php
                        } else {
                            ?>
                            <li class="link_accinfo"><a href="accountinfo.php"></a></li>
                        <?php } ?>
                        <!--join now and accinfo close-->
                        <li class="link_search"><a href="sitesearch.php"></a></li>
                        <li class="link_offic"><a href="official.php"></a></li>

                        <li class="link_upload"><a href="uregister.php"></a></li>
                        <li class="link_contact"><a href="contact.php"></a></li>
                    </ul>
                </div>

            </div>

            <div class="page-right">
                <div class="top">
                    <a href="home.php"><div class="mix-tape top_left" ></div></a>
                    <div class="releases top_left">
                        <a href="newsongs.php"><div class="new"></div></a>
                        <a href="oldsongs.php"><div class="old"></div></a>
                    </div>
                    <div class="blank top_left"></div>
                    <!-----login and logout start-->
                    <?php
                    if (empty($_SESSION['member_name'])) {
                        ?>
                        <a href="https://www.buymixtapes.com/memberlogin.php"><div class="members"></div></a>
                        <?php
                    } else {
                        ?>
                        <a href="https://www.buymixtapes.com/logout.php"><div class="logout"></div></a>
                    <?php } ?>
                    <!-----login and logout end-->
                </div>

            </div>
            <div id="main-music-container">
                <div class="downloadmixtape-logo"></div>
                <div class="page-top-mid"></div>
                <div class="page-right-corner"></div>

                <div class="music-content">

                    <div class="row">
                        <form action="#" method="post" name="download">
                            <table width="685" border="0" cellpadding="0" cellspacing="0" class="music-content_table">
                                <?
                                $db->beginTransaction();
                                $db->query = "select a.album_has_html_block_code, a.album_html_block_code, a.album_has_official_tag, md.music_director_name, a.custom_album_url, a.playlist_selected_color, a.player_top_bg, a.player_middle_bg, a.player_playlist_holder_bg, a.album_id, a.flamplayer_block,a.album_thumbnail,a.album_title,a.album_found,a.album_downimage,a.album_downrearimage,a.album_url,c.category_image_small,a.album_sharedlink,a.album_embededlink,a.album_totalscore,a.album_totalvote,a.album_2, ps.button_url, a.download_count FROM music_director md, album a, category c, player_settings ps WHERE md.music_director_id=a.music_director_id and a.category_id=c.category_id and a.album_homeflag=1 AND a.player_button_color = ps.id AND a.album_id='{$_REQUEST[album_id]}';";
                                $db->runQuery();
                                $music_array = $db->returnArrays();
                                $db->query = "select * from settings";
                                $db->runQuery();
                                $settings = $db->returnArrays();
                                $db->endTransaction();
                                $date = explode("-", $music_array[0]["album_found"]);
                                if ((int) $music_array[0]["album_totalvote"] == 0) {
                                    $average = 0;
                                } else {
                                    $average = round(((int) $music_array[0]["album_totalscore"] / (int) $music_array[0]["album_totalvote"]), 0);
                                }
                                ?>

                                <tr>
                                    <td>
                                        <!--PHP coding starts here-->

                                        <table width="685">
                                            <tr align="left" valign="middle">
                                                <td align="center" >
                                                    <?php
                                                    if ($vid >= 1) {
                                                        $msg = " **<font style='color:red; font-size: 10pt;'>Invalid Access Code, Please Try Again</font>** <br /><font style='color:black; font-size: 10pt; '>Premium members do not need to enter an access code<br /><br /> <font style='color:black; font-size: 10pt; font-weight: bold;'>Create Premium Membership Now!</b><br /><br /><a href='http://www.buymixtapes.com/join.php'><img src='images/join-now.png' border='0' width='73' height='22' alt='Join Now' title='Become a premium member today for no limits!'></a>";
                                                    }

                                                    if ($msgvar == 2) {
                                                        $msg = " **<font style='color:red; font-size: 10pt;'>All FREE Download Slots are Currently FULL</font>**<br /><font style='color:black; font-size: 10pt; '>Premium members have unlimited download slots<br /><br /><font style='color:black; font-size: 10pt; font-weight: bold;'>Create Premium Membership Now For No Wait!</b><br /><br /><a href='http://www.buymixtapes.com/join.php'><img src='images/join-now.png' border='0' width='73' height='22' alt='Join Now' title='Become a premium member today for no limits!'></a>";
                                                    }

                                                    if ($timecount >= 1) {
                                                        $msg = " **<font style='color:red; font-size: 10pt;'>Minimum wait time required between FREE downloads has not been reached.&nbsp;&nbsp;Please try again after</font>&nbsp;<font style='color:blac; font-size: 10pt;'>4 Hours</font>&nbsp;<font style='color:red; font-size: 10pt;'>from the completion of your free download</font>**&nbsp; <br /><br /><font style='color:black; font-size: 10pt; font-weight: bold;'>Create Premium Membership Now For No Wait!</b><br /><br /><a href='http://www.buymixtapes.com/join.php'><img src='images/join-now.png' border='0' width='73' height='22' alt='Join Now' title='Become a premium member today for no limits!'></a>";
                                                    }
                                                    ?>
                                                    <center>
                                                        <?php if ($msg): ?>
                                                            <div style="padding: 10px; width: 600px; margin: 0px 0px 5px; border: 1.4px solid red; line-height: 12px;" id="message">
                                                                <?php echo $msg; ?> <br />
                                                                <?php echo $int_html; ?>
                                                            </div>
                                                            <script>
                                                                var $j = jQuery.noConflict();

                                                                $j(document).ready(function(){
                                                                    var ot = $j('#main-music-container').offset().top;
                                                                    $j('html, body').animate({
                                                                        scrollTop:ot
                                                                    }, 'fast');
                                                                });
                                                            </script>
                                                        <?php endif; ?>
                                                    </center>
                                                </td>
                                            </tr>
                                        </table>

                                        <?php
                                        if ($music_array['0']["album_2"] == 0) {
                                            $img_src = "./members/images/" . $music_array[0]["album_thumbnail"];
                                            $popup_img_src = $img_src;
                                            if (!is_null($music_array['0']["album_downimage"])) {
                                                if (trim($music_array['0']["album_downimage"]) != "") {
                                                    $popup_img_src = "./members/images/" . $music_array[0]["album_downimage"];
                                                }
                                            }
                                        } elseif ($music_array['0']["album_2"] == 1) {
                                            $img_src = "./upload/members/images/" . $music_array[0]["album_thumbnail"];
                                            $popup_img_src = $img_src;
                                            if (!is_null($music_array['0']["album_downimage"])) {
                                                if (trim($music_array['0']["album_downimage"]) != "") {
                                                    $popup_img_src = "./upload/members/images/" . $music_array[0]["album_downimage"];
                                                }
                                            }
                                        }
                                        ?>
                                        <style type="text/css">
                                            .official-thumb
                                            {
                                                position: relative;
                                                display: block;
                                            }
                                            .offical-img
                                            {
                                                background: url('images/featured-official.png') no-repeat top right;
                                                position: absolute;
                                                width: 90px;
                                                height: 90px;
                                                top: -3px;
                                                right: 17px;
                                            }
                                            @media only screen and (max-width: 1000px), only screen and (max-device-width: 1000px) {
                                                .downloadmixtape-logo {
                                                    background: url(/images/info-mobile.png) no-repeat transparent;
                                                    background-size: 143px auto;
                                                    -webkit-background-size: 143px auto;
                                                    height: 35px;
                                                }
                                                .mobile_downloadfree_msg {
                                                    display: block;
                                                }
                                        </style>
                                        <script type="text/javascript" src="/js/jquery.fancybox.js"></script>
                                        <link rel="stylesheet" type="text/css" href="/css/fancybox/jquery.fancybox.css" />
                                        <script type="text/javascript">
                                            var $j = jQuery.noConflict();

                                            $j(document).ready(function() {

                                                $j('.embed').fancybox({
                                                    maxWidth      : 720,
                                                    maxHeight     : 300,
                                                    fitToView     : false,
                                                    autoSize      : false,
                                                    closeClick	: false,
                                                    openEffect	: 'none',
                                                    closeEffect	: 'none'
                                                });

                                                $j('#add-to-fav').fancybox({
                                                    maxWidth      : 1200,
                                                    maxHeight     : 900,
                                                    fitToView     : true,
                                                    autoSize      : false,
                                                    closeClick	: false,
                                                    openEffect	: 'none',
                                                    closeEffect	: 'none'
                                                });

                                                $j('#rate-mixtape').fancybox({
                                                    maxWidth      : 450,
                                                    maxHeight     : 237,
                                                    fitToView     : true,
                                                    autoSize      : false,
                                                    closeClick	: false,
                                                    'scrolling'   : 'no',
                                                    openEffect	: 'none',
                                                    closeEffect	: 'none',
                                                    padding       : 2,
                                                    margin        : 15
                                                });

                                                $j('#description').fancybox({
                                                    maxWidth      : 601,
                                                    maxHeight     : 625,
                                                    fitToView     : true,
                                                    autoSize      : false,
                                                    closeClick	: false,
                                                    openEffect	: 'none',
                                                    closeEffect	: 'none',
                                                    padding       : 2,
                                                    margin        : 15,
                                                    scrolling     : 'no'
                                                });

                                                $j("a#album_cover_to_popup").fancybox();

                                            });
                                        </script>
                                        <table width="689" border="0" class="player_table">

                                            <?php
                                            $db->beginTransaction();
                                            $db->query = "select song_id,song_name,song_url,download_rights,counter from songs where album_id='{$music_array['0']['album_id']}' order by song_id asc;";
                                            $db->runQuery();
                                            $song_array = $db->returnArrays();
                                            $db->endTransaction();

                                            $albumurl = $music_array['0']["album_url"];

                                            end($song_array);

                                            $full_mixtape = $song_array[key($song_array)];

                                            if ($music_array['0']["album_2"] == 0) {
                                                $fullmixtape_url = "members/mixtapes/" . trim($music_array['0']["album_url"]) . "/" . trim($full_mixtape['song_url']);
                                            } else if ($music_array['0']["album_2"] == 1) {
                                                $fullmixtape_url = "../" . trim($music_array['0']["album_url"]) . "/" . trim($full_mixtape['song_url']);
                                            }
                                            ?>
                                            <tr>
                                                <td align="center" colspan="2" class="Blackarial14" bgcolor="ffffff" width="40%" valign="top" >
                                                    <p class="official-thumb">
                                                        <a id="album_cover_to_popup" href="<?= $popup_img_src; ?>" title="<?= stripslashes($music_array[0]["album_title"]); ?>">
                                                            <?php if ($music_array[0]['album_has_official_tag'] == '1'): ?>
                                                                <span class="offical-img1"></span>
                                                            <?php endif; ?>
                                                            <img itemprop="image" src="<?php echo $img_src ?>" width="200px" border="0" alt="<?= stripslashes($music_array[0]["album_title"]); ?>"></a>
                                                    </p>
                                                    <p class="premium-button">
                                                        <?php $description_url = "/" . str_replace(" ", "-", $music_array[0]["music_director_name"]) . "-" . str_replace(" ", "-", $music_array[0]["album_title"]) . "." . $music_array[0]["album_id"] . ".description"; ?>
                                                        <a href="<?= $description_url; ?>" class="fancybox.ajax" id="description">
                                                            <img src="images/description.png" width="37" height="37" border="0" alt="Description and twitter info" title="Mixtape Description and Twitter Follow Info for DJ/Artist" />
                                                        </a>

                                                        <a href="#downloadfreemixtape">
                                                            <img src="images/download-now.png" width="37" height="37" border="0" alt="Download Now" title="Download Free" />
                                                        </a>


                                                        <a href="#comments">
                                                            <img src="images/comments.png" width="37" height="37" border="0" alt="Comment on this mixtape" title="Comments" />
                                                        </a>
                                                        <a href="addtofav-premium.php" class="fancybox.ajax" id="add-to-fav">
                                                            <img src="images/favorite-add2.png" width="37" height="37" border="0" alt="Premium account required to add to favorite's" title="Add To Favorites (Premium Account Required)" />
                                                        </a>

                                                        <a href="#" onclick="window.open('http://www.buymixtapes.com/popout-player.php?album_id=<?php echo $_REQUEST['album_id']; ?>','popOutPlayer','width=330,height=419'); " >
                                                            <img src="images/popout-player.png" width="37" height="37" border="0" alt="Pop out the mixtape player.  This option displays full Screen on mobile devices" title="Pop Out Mixtape Player.  Use this on mobile phones as it loads the mixtape player in a new window, full screen!" />
                                                        </a>

                                                        <!-- Embed code -->
                                                        <a href="#player-embed-code" class="embed player_embed_link"><img src="images/embed3.png" width="37" height="37" border="0" alt="Embed player code" title="Embed Player Code.  Put this mixtape player on your website/blog!"></a>
                                                    <div id="player-embed-code" style="display: none; margin: 30px 0 0 0;">
                                                        <font style="color:black; font-size: 10pt;">Embed player only: Copy and paste the code from the 1st box below to your website</font>
                                                        <textarea name="" cols="70" rows="4" style="font-size: 16px; padding: 10px 5px 0 5px; border: 1px solid #111;"><iframe src="https://www.buymixtapes.com/embedplayeronly.php?sec=<?php echo $_REQUEST['album_id']; ?>" width="430" height="440" frameBorder="no" style="border:0 none transparent; overflow: hidden;"></iframe></textarea>
                                                        <br /><br />
                                                        <font style="color:black; font-size: 10pt;">Embed full mixtape: Copy and paste the code from the 2nd box below to your website</font>
                                                        <textarea name="" cols="70" rows="4" style="font-size: 16px; padding: 10px 5px 0 5px; border: 1px solid #111;"><iframe src="https://www.buymixtapes.com/embedfullplayer.php?sec=<?php echo $_REQUEST['album_id']; ?>" width="665" height="410" frameBorder="no" style="border:0 none transparent; overflow: hidden;"></iframe></textarea>
                                                    </div>
                                                    </p>
                                                    <p class="album-title">

                                                        <style>
                                                            h1{font-size: 11pt;}
                                                        </style>

                                                    <h1 itemprop="name">
                                                        <?php
                                                        $txt_link = stripslashes($music_array[0]["music_director_name"]) . ": " . stripslashes($music_array[0]["album_title"]);
                                                        if (strlen($txt_link) > 29) {
                                                            $final_txt_link = stripslashes($music_array[0]["music_director_name"]) . ": <b>" . stripslashes($music_array[0]["album_title"]) . "</b>";
                                                            //echo substr($final_txt_link, 0, 29)."<br/>".substr($final_txt_link,29);
                                                            $tstr = truncate_str($final_txt_link, 29);
                                                            echo $tstr . "<br/>" . str_replace($tstr, "", $final_txt_link);
                                                        } else {
                                                            $final_txt_link = stripslashes($music_array[0]["music_director_name"]) . ": <b>" . stripslashes($music_array[0]["album_title"]) . "</b>";
                                                            echo $final_txt_link;
                                                        }
                                                        ?>
                                                    </h1>

                                                    <? $mixtape = stripslashes($music_array[0]["album_title"]); ?>
                                                    </p>
                                                    <p class="album-title">
                                                        <b> Street Date:
                                                            <?= $date[1] ?>
                                                            .
                                                            <?= $date[2] ?>
                                                            .
                                                            <?= $date[0] ?>
                                                        </b>
                                                    </p>

                                                    <table width="97%" cellspacing="0" cellpadding="0" align="center">
                                                        <tr>
                                                            <td colspan="5" align="center"><strong></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="middle" colspan="5">
                                                                <div class="star1" data-score="<?php echo $average; ?>" id="<?php echo $music_array['0']['album_id']; ?>">
                                                                    <?php
                                                                    for ($f = 1; $f <= 5; $f++) {
                                                                        if ($f <= $average) {
                                                                            ?>
                                                                            <a href="ratemixtape-new.php?album_id=<?php echo $album_id; ?>" class="fancybox.ajax" id="rate-mixtape"><img src="images/star-on.png" width="25" height="25" border="0" alt="Give your rating" title="Click to give your star rating"></a>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <a href="ratemixtape-new.php?album_id=<?php echo $album_id; ?>" class="fancybox.ajax" id="rate-mixtape"><img src="images/star-off.png" width="25" height="25" border="0" alt="Give your rating" title="Click to give your star rating"></a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div id="vote-submitted1" style="height: 10px">&nbsp;</div>
                                                            </td>
                                                        </tr>
                                                        <!-- <tr><td colspan=5 align=center><font style="font-size: 10pt;">Views:</font> <font style="font-size: 10pt; font-weight: bold; "><?php echo number_format($music_array[0]['download_count'] * 56); ?></font></td></tr> -->
                                                        <tr class="album_share">
                                                            <?php
                                                            $page_url = str_replace(".premium", ".mixtape", $_SERVER["REQUEST_URI"]);
                                                            $short_url = "buymixtap.es/m." . $album_id;
                                                            ?>

                                                            <td colspan="5" align="center" style="height:50px;vertical-align:middle;"><br />
                                                                <iframe src="//www.facebook.com/plugins/like.php?href=http://www.buymixtapes.com<?php echo urlencode($page_url); ?>&amp;width=95&amp;layout=button&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=20&amp;appId=126223704088492&amp;" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:95px; height:20px;" allowTransparency="true"></iframe>
                                                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $short_url; ?>" data-text="<?= $desc . "" . $short_url . $album_twitter . $director_twitter ?> @buymixtapes" data-count="none">Tweet</a>
                                                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>


                                                            </td>
                                                        </tr>


                                                    </table>

                                                </td>

                                                <!-- Insert HTML5 Player Here -->
                                                <td align="left" width="58%" valign="top" style="border-collapse:separate;">

                                                    <?php
                                                    include 'html5-player-include-new-edge.php';
                                                    //echo '*Load our website on your mobile browser.  Our mixtape player is mobile compatible!  Just tap the orange music note icon.'
                                                    #echo stripslashes($music_array[0]['flamplayer_block']);
                                                    ?>
                                                </td>


                                                </td>
                                            </tr>
                                        </table>
                                        <?php
                                        if (strlen($txt_link) > 29) {
                                            ?>
                                            <div style="margin:0px 0px 0px 286px;" class="pls-make-sure">*Mobile compatible mixtape player loads full screen, just tap the orange music note icon on your mobile browser.</div>
                                            <?php
                                        } else {
                                            ?>
                                            <div style="margin:15px 0px 0px 286px;" class="pls-make-sure">*Mobile compatible mixtape player loads full screen, just tap the orange music note icon on your mobile browser.</div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <style type="text/css">
                                .suggested-mixed-tapes
                                {
                                    margin: 10px 0;
                                }
                                iframe {
                                    height:25px; width:54px;
                                }
                                .suggested-mixed-tapes h2
                                {
                                    font-size: 14px;
                                    text-align: left;
                                    margin-bottom:10px;
                                    color:#000;
                                }

                                .owl-item
                                {
                                    text-align: center;
                                }
                                .mixtapes-container{position: relative;padding: 6px 6px 6px 0;    float: left;overflow: hidden;}

                                .mixtapes-container span.offical-img
                                {
                                    background: url('images/featured-official.png') no-repeat top right;
                                    width: 90px;
                                    height: 90px;
                                    position: absolute;
                                    top: 3px;
                                    right: 6px;
                                }
                                span.offical-img1
                                {
                                    background: url('images/featured-official.png') no-repeat top right;
                                    width: 90px;
                                    height: 90px;
                                    position: absolute;
                                    top: -3px;
                                    right: 27px;
                                }

                                .mixtapes-container img
                                {
                                    width: 97%;
                                }
                                #msg_tr a {
                                    display: inline-block;
                                    position: relative;
                                }
                                #msg_tr {
                                    color: black;
                                    font-size: 14px;
                                }
                                #msg_tr span {
                                    color: red;
                                }
                                .suggested-mixed-tapes .owl-pagination{display:none !important;}
                            </style>
                            <?php
                            $db->beginTransaction();
                            $db->query = "SELECT `music_director_id` FROM `album` WHERE `album_id` = '" . $_REQUEST['album_id'] . "' ";
                            $db->runQuery();
                            $music_director = $db->returnArrays();

                            $music_director_id = $music_director['0']['music_director_id'];

                            $db->endTransaction();

                            $album_found = $music_array[0]["album_found"];

                            $db->beginTransaction();
                            $db->query = "SELECT `album_found` FROM `album` WHERE `music_director_id` = '" . $music_director_id . "' AND `album_id` != '" . $_REQUEST['album_id'] . "' AND `album_found` < '$album_found' ORDER BY `album_found` desc LIMIT 1";
                            $db->runQuery();
                            $suggested_album_arr_older = $db->returnArrays();
                            $db->endTransaction();

                            $db->beginTransaction();
                            $db->query = "SELECT COUNT(*) as 'count' FROM `album` WHERE `music_director_id` = '" . $music_director_id . "' AND `album_id` != '" . $_REQUEST['album_id'] . "'";
                            $db->runQuery();
                            $suggested_album_arr_count = $db->returnArrays();
                            $suggested_album_arr_count = $suggested_album_arr_count[0]['count'];
                            $db->endTransaction();
                            ?>

                            <!-- Suggested Mixtapes -->
                            <link rel="stylesheet" href="script/owl/owl.carousel.css">
                            <link rel="stylesheet" href="script/owl/owl.theme.css">
                            <script src="script/owl/owl.carousel.min.js"></script>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    var owl = $(".suggested-mixed-tapes .owl").owlCarousel({
                                        items: 4,
                                        itemsCustom: [[0, 2], [500, 3], [660, 4]],
                                        navigation: true,
                                        navigationText:	["< newer","older >"],
                                        rewindNav : false,
                                        scrollPerPage: true,
                                        lazyLoad : true,
                                        jsonPath : 'suggest_more_mixtapes_json.php?d=<?=$music_director_id?>&a=<?=$_REQUEST['album_id']?>&premium=0',
                                        jsonSuccess : function(data){
                                            var content = "";
                                            $.each(data,function(i,item){
                                                content += '<div class="mixtapes-container" data-found="'+item.found+'">'+
                                                    '<a href="'+item.link+'">'+
                                                    (item.tag ? '<span class="offical-img"></span>':'')+
                                                    '<img  border="0" align="middle" class="lazyOwl" title="'+item.title+'" data-src="./upload/members/images/'+item.thumbnail+'">'+
                                                    '</a>'+
                                                    '</div>';
                                            });
                                            $(".suggested-mixed-tapes .owl").html(content);
                                        },
                                        afterInit: function(){
                                            setTimeout(function(){
                                                var owl = $(".owl-carousel");
                                                var base = owl.data('owlCarousel');
                                                var index = $('.owl-item>div[data-found='+owl.data('current')+']',owl).parent().index();
                                                base.jumpTo(index);
                                            },100);
                                        }
                                    });
                                });
                            </script>
                            <div class="suggested-mixed-tapes">
                                <hr/>
                                <h2>Suggested Mixtapes</h2>
                                <?php if ($suggested_album_arr_count): ?>
                                    <div class="owl" data-current="<?=$suggested_album_arr_older[0]['album_found']?>"></div>
                                <?php else: ?>
                                    <p>No other mixtapes found by this DJ/artist.</p>
                                <?php endif; ?>
                            </div>
                            <a name="downloadfreemixtape"></a><center>
                                <table id="platinumtable" width="680" height="411" cellpadding="5" cellspacing="0" border="0" bordercolor="#d4d5d7" style="background-image: url(/images/music_background3.jpg); background-position: center; background-repeat:no-repeat; background-size:680px 411px;"><br>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td align="center" width="290px" height="110px" class="platinumtable_hide"><img src="images/choose-download.png" border="0" width="115" height="104" alt="Choose Download" class="platinumtable_hide" title="Choose Your Download"></td><td align="center" width="150px"><img src="images/premium.png" border="0" width="100" height="102" alt="Premium Download" title="Premium Download"></td><td align="center"><img src="images/freedownload.png" border="0" width="100" height="102" alt="Free Download" title="Free Download"></td></tr>
                                    <tr><td class="platinumtable_left_td"><font style="color:white; font-size: 10pt;">Download Multiple Files/Mixtapes At Once</td><td align="center" class="platinumtable_hide" ><img src="images/checkmark-icon.png" width="20" height="20" border="0" alt="Checkmark" title="Download as much as you like at the same time." class="platinumtable_hide"></b></td><td align="center"><img src="images/red-x.png" width="20" height="20" border="0" alt="Red X" title="Must have a premium membership to use this feature."></td></tr>
                                    <tr><td class="platinumtable_left_td"><font style="color:white; font-size: 10pt;">Download Single Tracks</td><td align="center" class="platinumtable_hide" ><img src="images/checkmark-icon.png" class="platinumtable_hide" width="20" height="20" border="0" alt="Checkmark" title="When you don't want to download the whole mixtape."></b></td><td align="center"><img src="images/red-x.png" width="20" height="20" border="0" alt="Red X" title="Only premium users can download single tracks."></td></tr>
                                    <tr><td class="platinumtable_left_td"><font style="color:white; font-size: 10pt;">Download All Mixtapes</td><td align="center" class="platinumtable_hide" ><img src="images/checkmark-icon.png" class="platinumtable_hide" width="20" height="20" border="0" alt="Checkmark" title="Choose from our huge selection of mixtapes."></td><td align="center"><img src="images/red-x.png" width="20" height="20" border="0" border="0" alt="Red X" title="Premium account required to access all mixtapes."></td></tr>
                                    <tr><td class="platinumtable_left_td"><font style="color:white; font-size: 10pt;">No Wait Between Downloads</td><td align="center" class="platinumtable_hide" ><img src="images/checkmark-icon.png" class="platinumtable_hide" width="20" height="20" border="0" alt="Checkmark" title="No need to wait!"></td><td align="center"><img src="images/red-x.png" width="20" height="20" border="0" alt="Red X" title="15 minute wait time between downloads."></td></tr>
                                    <tr><td class="platinumtable_left_td"><font style="color:white; font-size: 10pt;">Unlimited Download Speed</td><td align="center" class="platinumtable_hide" ><img src="images/checkmark-icon.png" class="platinumtable_hide" width="20" height="20" border="0" alt="Checkmark" title="No speed cap, unlimited download speed!"></td><td align="center"><font style="color:white; font-size: 10pt; font-weight: bold;"><img src="images/checkmark-icon.png" width="20" height="20" border="0" alt="Checkmark" title="No speed cap, unlimited download speed!"></td></tr>
                                    <tr><td class="platinumtable_hide"><font style="color:white; font-size: 10pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Download</b></td>
                                        <td align="center" >
                                            <p class="pls-make-sure">
                                                <a href="http://www.buymixtapes.com/join.php">
                                                    <img class="join_now_img_responsive" src="mobile-join.jpg" alt="Join now for premium access" width="81" height="26" border="0" alt="Join Now" title="Become a premium member today for no limits!">
                                                    <img class="join_now_img" src="mobile-join.jpg" alt="Join now for premium access" width="81" height="26" border="0" alt="Join Now" title="Become a premium member today for no limits!">
                                                </a>
                                        </td></center>
                            <td align="center"><br/>
                                <?php if($row1['album_is_official'] == 1)
                                { ?>
                                    <img class="access_code_img_responsive" src="mobile-access.jpg" alt="Enter Access Code" width="81" height="26" border="0" title="Enter the access code below to begin your free download">
                                    <img class="access_code_img" src="mobile-access.jpg" alt="Enter Access Code" width="81" height="26" border="0" title="Enter the access code below to begin your free download">
                                    <?php
                                }
                                else
                                { ?>
                                    <img class="access_code_img_responsive" src="premium_download.png" alt="Enter Access Code" width="81" height="26" border="0" title="This download is only available to Premium Members.  Join now and create your Premium Account today!">
                                    <img class="access_code_img" src="images/premium_required.png" alt="Enter Access Code" width="81" height="26" border="0" title="Join now and create your Premium Account today!">
                                <?php } ?>
                    </div></p></td>
                    <tr><td>&nbsp;</td></tr>
                    </tr>
                    </table>
                    <div width="685" border="0">
                        <?php if($row1['album_is_official'] == 1)
                        { ?>

                            <div align="center" style="background-color:#2E71C2; padding-top:5px; padding-bottom:5px;"><font style="color:white; font-size:12pt; font-weight:bold;">Access Code:&nbsp;
                                    <?
                                    $number = substr(rand(), 0, 4);
                                    echo $number;
                                    ?>
                                    <input type="hidden" name="numbercheck" id="numbercheck" value="<?= $number ?>" >
                                </font>
                            </div>

                            <div style="margin-top:10px; margin-bottom:-3px;"><font style="color:black; font-size:12pt;">Enter Access Code:</font>
                                <input type="text" name="number" id="checknumberblank" value="<?= $_POST['number'] ?>" size="13">
                            </div>

                            <div align="center" valign="middle" id="download_button_tr" class="Blackver">
                                <br /><input type="image" src="images/downloadfree-buttonblue6.png" width="180" height="42" border="0" title="Download mixtape free" name="submit" id="submitbutton">
                            </div>
                            <div class="mobile_downloadfree_msg" style="margin-top:7px; margin-bottom:-10px;"><font style="font-size: 12px; color:black;">&#8226;Once download is complete, browse to the folder saved to and extract the mp3 tracks from the file</font></div>

                            <?php
                        }
                        else
                        { ?>
                            <div align="center" style="background-color:#2E71C2; padding-top:5px; padding-bottom:5px;"><font style="color:white; font-size:12pt; font-weight:bold;">This Download Is Unavailable To Free Users</font></div>
                            <div align="center" valign="middle" id="download_button_tr" >
                                <div style="font-size:14px; color:red; margin-top:5px;">Only Premium Members have the option to download this product.  Create your Premium Membership today to unlock all/unlimited mixtape downloads!</div>
                                <br />

                                <a href='http://www.buymixtapes.com/join.php'><img src='images/joinnow_msg5.png' alt='Join now for premium access' width='100' height='28' border='0' title='Become a premium member today for no limits!' /></a>
                                <br /><br />
                                <div style="font-size:12px; color:black; margin-bottom:-10px;">*Products that have an Official tag or located in the Official section are free to download for all users.</div>

                            </div>
                        <?php } ?>
                        <div align='center' valign='middle' id="msg_tr">

                        </div>
                    </div>
                    <div width="685" border="0">


                        <a name="comments">
                            <tr>
                                <br />
                                <div align="center" style="background-color:#2E71C2; padding-top:5px; padding-bottom:5px;"><font style="color:white; font-size:12pt; font-weight:bold;">Post Your Comments</div>  </tr>
                            <tr>

                                <td align="left">
                                    <br />
                                    <div id="disqus_thread"></div>
                                    <script type="text/javascript">
                                        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                                        var disqus_shortname = 'buymixtapes'; // required: replace example with your forum shortname
                                        var disqus_identifier = '<?php echo urlencode($_REQUEST['album_id']); ?>';

                                        /* * * DON'T EDIT BELOW THIS LINE * * */
                                        (function() {
                                            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                        })();
                                    </script>
                                    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
                                </td>


                            </tr>


                    </div>



                    </form>
                </div>
                <div class="ads_join">
                    <!-- insert_banner -->
                    <div style="padding-top:20px;">
                        <a href="join.php" border="0"><img src="images/premium-ad-cottoncandy-opt.gif" border="0" width="160" height="600" alt="Look at all the benefits when becoming a member" title="Premium membership benefits"></a>
                    </div>

                    <div style="padding-top:75px;">
                        <a href="join.php" border="0"><img src="images/buymixtapes_banner2-opt.gif" border="0" width="160" height="600" alt="Here are the premium features" title="What are you waiting for?  To download another free mixtape?  Join Now and create your premium membership now for no waiting and no limits!"></a>
                    </div>

                    <!-- insert_banner -->
                </div>
                <div style="clear:both"></div>
            </div>




        </div>

        <div class="footer">
            <div class="footer_left">
                <div class="bottom_left"></div>
            </div>
            <div class="footer_right">
                <div class="footer_right_sub1">
                    <div class="bottom_middle_line_bg1"></div>
                    <div class="bottom_middle_line_bg2"></div>
                </div>

                <div class="bottom_menu">
                    <ul>

                        <a href="home.php"><li class="link_home_footer"></li></a>
                        <a href="newsongs.php"><li class="link_new_footer"></li></a>
                        <a href="mixtapes.php"><li class="link_mix_footer"></li></a>
                        <a href="oldsongs.php"><li class="link_old_footer"></li></a>
                        <a href="join.php"><li class="link_join_footer"></li></a>
                        <a href="/"><li class="link_about_footer"></li></a>
                        <a href="http://www.buymixtapes.com/blog" target="new"><li class="link_blog_footer"></li></a>
                    </ul>
                </div>

                <div class="footer_right_sub3">
                    <div class="bottom_middle_bg1"></div>
                    <div class="bottom_middle_bg2">
                        <h6>Copyright 2002-2016 Buymixtapes Incorporated. Disclaimer: All music on this site is free and for promotional use only.  None of the music is for sale.</h6>
                    </div>
                    <div class="bottom_right"></div>
                </div>

            </div>
        </div>
    </div>

    <!-- .footer ends -->
</div><!-- .page ends -->




</div><!-- .main-body ends -->

</body>
<?php

function truncate_str($str, $maxlen) {
    if (strlen($str) <= $maxlen)
        return $str;

    $newstr = substr($str, 0, $maxlen);
    if (substr($newstr, -1, 1) != ' ')
        $newstr = substr($newstr, 0, strrpos($newstr, " "));

    return $newstr;
}
?>