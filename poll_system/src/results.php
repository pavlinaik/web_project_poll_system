<?php
    require_once "./vote.php";
    require_once "./poll.php";
    session_start();
    if($_GET) {
        $pollId = isset($_GET['pollID']) ? modifyInput($_GET['pollID']) : '';
        $poll = new Poll();
        $pollInfo = $poll->getPollWithOptionsById($pollId);
        $vote = new Vote();
        $ratingsPerOption = array();
        $allVotesRating = 0.0;
        $voteCnt = 0;
        foreach ($pollInfo['options'] as $option){
            $votesForOption = $vote->getVotesForPollOption($pollId, $option['id']);
            $ratingsPerOption[$option['id']] = 0.0;
            
            foreach ($votesForOption as $v){
                $ratingsPerOption[$option['id']] += $v['rating'];
                $allVotesRating += $v['rating'];
                $voteCnt++;
            }
        }
        $percentPerOption = array();
        foreach ($pollInfo['options'] as $option) {
            $percentPerOption[$option['id']] =  $allVotesRating ? round(($ratingsPerOption[$option['id']]/$allVotesRating)*100): 0;
        }
    } else {
        http_response_code(400);
        echo 'Invalid request';
    }
    function modifyInput($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        return $text;
    }
?>
<div id="container">
<h1><?php echo $pollInfo['poll']['question']; ?></h1>
<p><b>Total Votes:</b> <?php echo $voteCnt; ?></p>
<?php
    $i=0;
    $cnt = 0;
    //Option bar color class array
    $barColorArr = array('azure','emerald','violet','yellow','red');
    //Generate option bars with votes count
    foreach($percentPerOption as $optId=>$percent){
        $percent = $percent . '%';
        //Define bar color class
        if(!array_key_exists($i, $barColorArr)){
            $i=0;
        }
        $barColor = $barColorArr[$i];
?>
<div class="bar-main-container <?php echo $barColor; ?>">
  <div class="txt"><?php echo $pollInfo['options'][$cnt]['content']; ?></div>
  <div class="wrap">
    <div class="bar-percentage"><?php echo $percent; ?></div>
    <div class="bar-container">
      <div class="bar" style="width: <?php echo $percent; ?>;"></div>
    </div>
  </div>
</div>
<?php $i++; $cnt++;} ?>
<a href=<?php echo $_SESSION['role']?"../manage_polls.html":"../poll_results.html"; ?>>Back to poll results ➡ </a>
</div>

<style>
#container { text-align: center; margin: 20px; }
a { text-decoration: none; 
    color: #1FCC44; 
    font-size: 20px;
    font-weight: bold;
}
.txt {
    text-align: center;
}
.bar-main-container {
    margin: 10px auto;
    width: 300px;
    height: 55px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    font-family: sans-serif;
    font-weight: normal;
    font-size: 0.8em;
    color: #FFF;
}
.wrap { padding: 8px; }
.bar-percentage {
    float: left;
    background: rgba(0,0,0,0.13);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    padding: 9px 0px;
    width: 18%;
    height: 16px;
    margin-top: -15px;
    text-align: center;
}
.bar-container {
    float: right;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    height: 10px;
    background: rgba(0,0,0,0.13);
    width: 78%;
    margin: 0px 0px;
    overflow: hidden;
}
.bar-main-container .txt{
    padding-top: 5px;
    font-size: 16px;
    font-weight: bold;
}

.bar {
    float: left;
    background: #FFF;
    height: 100%;
    -webkit-border-radius: 10px 0px 0px 10px;
    -moz-border-radius: 10px 0px 0px 10px;
    border-radius: 10px 0px 0px 10px;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    filter: alpha(opacity=100);
    -moz-opacity: 1;
    -khtml-opacity: 1;
    opacity: 1;
}

/* COLORS */
.azure   { background: #38B1CC; }
.emerald { background: #2CB299; }
.violet  { background: #8E5D9F; }
.yellow  { background: #EFC32F; }
.red     { background: #E44C41; }
</style>