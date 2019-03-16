<?php require('inc/loginrequire.php'); ?>



<?php include 'inc/header.php'; ?>
    <form method="POST">
        <input type="text" name="eventname" placeholder="event name">
        <br>
        <textarea name="eventdesc" rows="10" placeholder="event description"></textarea>
        <br>
        <input type="text" name="duration" placeholder="duration">
        <br>
        <input type="date" name="eventdate" placeholder="event date">
        <br>
        <label for="formal">
        <input type="radio" name="type" id="formal" value="formal">Formal
        </label>
        <label for="informal">
        <input type="radio" name="type" id="informal" value="informal">Informal
        </label>
        <input type="submit">        
    </form>
<?php include 'inc/footer.php'; ?>