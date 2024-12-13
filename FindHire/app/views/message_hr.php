<?php include 'layout/header.php'; ?>

<h1>Send Follow-up Message</h1>
<form action="message_action.php" method="POST">
    <textarea name="message" placeholder="Write your message here..."></textarea>
    <button type="submit">Send Message</button>
</form>

<?php include 'layout/footer.php'; ?>
