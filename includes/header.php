<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/media.css">
    <title>Main</title>
</head>

<body>
    <div id="hiddenContent">
    <header>
    <h2 id="logo"><a href="main.php">Jensen Online</a></h2>
 <ul id="menu">
      <li><a href=""><span id='user_welcome'>Klasser</span></a>
        <ul>
        <li><a href="wuk.php">Wuk</a></li>
        <li><a href="cobol.php">Cobol</a></li>
        <li><a href="pro.php">Projektledare</a></li>
        <li><a href="it.php">IT-testare</a></li>
        </ul>
      </li>
      <li><a href="kontakt.php"><span id='user_welcome'>Kontakt</span></a>
      </li>
      <li><a href=""><?php if(logged_in() === true){ echo "<span id='user_welcome'>Profil </span>".$user_data['first_name']." ".$user_data['last_name']; }?></a>
        <ul>
        <?php if($user_data['type'] == 1)echo "<li><a href='admin.php'>Admin</a></li>"?>
        <?php if($user_data['type'] == 2 /*|| $user_data['type'] == 1*/)echo "<li><a href='teacher.php'>Lärare</a></li>"?>
        <?php if ($user_data['type'] == 2)echo "<li><a href='teacher_recieved.php'>Mottagna filer</a></li>"?>      
        <?php if($user_data['type'] == 2 || $user_data['type'] == 1)echo "<li><a href='admin_forum.php'>Forum</a></li>"?> 
        <?php if (/*($user_data['type'] == 2 || $user_data['type'] == 1 ||*/ $user_data['type'] == 0)echo "<li><a href='kurs.php'>Mottagna filer</a></li>"?> 
        <?php if (/*($user_data['type'] == 2 || $user_data['type'] == 1 ||*/ $user_data['type'] == 0)echo "<li><a href='ladda.php'>Ladda upp</a></li>"?>    
        <li><a href="profile.php">Ändra lösenord</a></li>
        <li><a href="test_logout.php">Logga ut</a></li>
        </ul>
      </li>
    </ul>
</header>
    </div>        