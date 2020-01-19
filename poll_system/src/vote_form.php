<?php
    require_once "./poll.php";
    header("Content-type: application/json");
    $poll = new Poll();
    $pollData = $poll->getPollWithOptionsById($_POST['poll_number']);
?>
<!-- <div class="pollContent">
    <?php echo !empty($statusMsg)?'<p class="stmsg">'.$statusMsg.'</p>':''; ?>
    <form action="" method="POST" name="pollFrm">
    <h3><?php echo $pollData['poll']['question']; ?></h3>
    <ul>
        <?php foreach($pollData['options'] as $opt){
            echo '<li><input type="radio" name="voteOpt" value="'.$opt['id'].'" >'.$opt['content'].'</li>';
        } ?>
    </ul>
    <input type="hidden" name="pollID" value="<?php echo $pollData['poll']['id']; ?>">
    <input type="submit" name="voteSubmit" class="button" value="Vote">
    <a href="results.php?pollID=<?php echo $pollData['poll']['id']; ?>">Results</a>
    </form>
</div>

<?php
//if vote is submitted
if(isset($_POST['voteSubmit'])){
    $voteData = array(
        'poll_id' => $_POST['pollID'],
        'poll_option_id' => $_POST['voteOpt']
    );
    //insert vote data
    $voteSubmit = $poll->vote($voteData);
    if($voteSubmit){
        //store in $_COOKIE to signify the user has voted
        setcookie($_POST['pollID'], 1, time()+60*60*24*365);
        
        $statusMsg = 'Your vote has been submitted successfully.';
    }else{
        $statusMsg = 'Your vote already had submitted.';
    }
}
?> -->