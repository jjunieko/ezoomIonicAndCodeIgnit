<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <div>
        <h1>ID</h1>
        <h2>NAME</h2>
        <h3>USERNAME</h3>
        <h4>EMAIL</h4>
        <?php foreach($users as $user):?>
        <p>xxxxxxxxxxxxxxxxxxx</p>
        <h1><?php echo $user['id'] ?></h1>
        <h2><?php echo $user['name'] ?></h2>
        <h3><?php echo $user['username'] ?></h3>
        <h4><?php echo $user['email'] ?></h4>


        <?php endforeach ?>
    </div>
</body>
</html>