<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Montserrat', sans-serif;
            background-color: #EAEDF8;
            margin: 0;
        }
        .footer{
            padding: 100px;
            text-align:center;
            background-color: #343434;
            color: white;
            margin-top: 300px;
        }

        .main{
            display:flex;
        }

        .menu{
            width:20%;
            background-color: #838aa5;
            margin-right: 32px;
            padding-top: 150px;
            height: 100vh;
        }

        .menu a{
            display:block;
            text-decoration: none;
            color: white;
            padding: 8px;
            display: flex;
            align-items: center;
        }

        .menu img{
            margin-right: 8px;
        }

        .menu a:hover{
            background-color: rgba(255,255,255,0.1);
        }

        
        .content{
            width:80%;
            margin-top:120px;
            margin-right: 32px;
            background-color: white;
            border-radius: 8px;
            padding: 8px;
        }

        .menubar{
            background-color: white;
            position: absolute;
            left:0;
            right:0;
            top:0;
            height: 80px;
            box-shadow: 2px 2px 2px 2px rgba(0,0,0,0.1);
            padding-left: 50px;
            display: flex;
            justify-content: space-between;
        }

        .avatar{
            width:16px;
            height:16px;
            border-radius: 100%;
            background-color:#b5bad0;
            padding: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 8px;
        }

        .myname{
            display:flex;
            margin-right: 50px;
            align-items: center;
        }

        .card{
            background-color: rgba(0,0,0,0.05);
            margin-bottom:  16px;
            border-radius: 8px;
            padding: 8px;
            padding-left: 48px;
            padding-left: 64px;
            position: relative;
        }
        
        .profile_picture{
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border:2px solid white;
            position: absolute;
            left:8px;
            bottom: 2px;
        }

        .phonebtn{
            background-color:#b5bad0;
            color: #000;
            padding: 4px;
            text-decoration: none;
            border-radius: 4px;
            position: absolute;
            top: 0px;
            right: 0px;
        }

        .phonebtn:hover{
            background-color: #838aa5;
        }

        .deletebtn {
            background-color: #ff003bab;
            padding: 4px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            position: absolute;
            bottom: 0px;
            height: 15px;
            width: 65px;
            right: 0px;
        }

        .deletebtn:hover {
            background-color: #FF3333;
        }
    </style>

</head>

<body>
    <div class="menubar">
        <h1>My Contact Book</h1>

        <div class="myname">
            <div class = "avatar">C</div>Carolin Birkmann
        </div>
    </div>

    <div class="main"> <!--Menüleiste / Seiten-->
        <div class="menu">
            <a href="index.php?page=start"><img src='img/home.svg'>Start</a> <!--Variable page bekommt Wert "start"-->
            <a href="index.php?page=contacts"><img src='img/book.svg'>Kontakte</a><!--Variable page bekommt Wert "contacts"-->
            <a href="index.php?page=addcontact"><img src='img/add.svg'>Kontakt hinzufügen</a><!--Variable page bekommt Wert "addcontact"-->
            <a href="index.php?page=legal"><img src='img/legal.svg'>Impressum</a><!--Variable page bekommt Wert "legal"-->
        </div>

        <div class="content">

        <?php
            $headline = 'Herzlich Willkommen';
            $contacts =[];


            //Kontakteingabe in txt Datei speicher:
            if(file_exists('contacts.txt')){ //wenn Datei existiert, dann...

                $text = file_get_contents('contacts.txt',true); //Variable $text = Text aus datei wird ausgelesen
                $contacts = json_decode($text, true); // Variable $contacts = Text wird in JSON-Array umgewandelt
            }
            //Neuen Kontakt in Array hinzufügen:
            if(isset($_POST['name']) && isset($_POST['phone'])){ // Wenn Name & Phone eingegeben wurden, dann...
                echo 'Kontakt <b>'. $_POST['name']. '</b> wurde hinzugefügt'; //...gib diesen Satz aus

                $newContact =[  	           //neuer Kontakt Array
                    'name' => $_POST['name'], //name:...
                    'phone' => $_POST['phone']//phone:...
                ];
                array_push($contacts, $newContact); //mit push wird neuer Datensatz(newContact) in Array contacst hinten angefügt
                file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT)); //Array wird in Text umgewandelt
            }

            //ÜBERSCHRIFTEN je nach Seitenauswahl:
            if($_GET['page'] == 'delete'){
                $headline = 'Kontakt gelöscht';
            }

            if($_GET['page'] == 'contacts'){
                $headline = 'Deine Kontakte';
            }

            if($_GET['page'] == 'legal'){
                $headline = 'Impressum';
            }

            if($_GET['page'] == 'addcontact'){
                $headline = 'Kontakt hinzufügen';
            }
            //_____________________________________


            echo '<h1>' . $headline . '</h1>'; //Wert aus URL Parameter / Variable page



            //Datensatz LÖSCHEN:

            if($_GET['page'] == 'delete'){
                echo '<p>Dein Kontakt wurde gelöscht</p>';
                # Wir laden die Nummer der Reihe aus den URL Parametern
                $index = $_GET['delete']; 

                # Wir löschen die Stelle aus dem Array 
                unset($contacts[$index]); 

                # Tabelle erneut speichern in Datei contacts.txt
                file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
            

            //Datensätze ÜBERBLICK:
            }elseif($_GET['page'] == 'contacts'){

            echo "<p>Auf dieser Seite hast du einen Überblick über deine <b>Kontakte</b></p>";
            
                //Datensätze AUFLISTEN:
                foreach($contacts as $index=>$row){ //Array conacts durchgehen nach einzelnen Zeilen ($row) (geht alle verfügbaren Reihen durch)
                        //index von contacts - deren Inhalt (row)
                        $name = $row['name'];
                        $phone = $row['phone'];

                        echo"
                        <div class='card'>
                        <img class='profile_picture' src='img/profile-picture.svg'>
                        <b>$name</b><br>
                        $phone

                        <a class='phonebtn' href='tel:$phone'>Anrufen</a> 
                        <a class='deletebtn' href='?page=delete&delete=$index'>Löschen</a>
                        </div>
                        ";
                    }

            // Seite Impressum aufrufen
            }elseif ($_GET['page'] == 'legal'){

                echo 'Hier ist das Impressum';

            // Seite Kontakte hinzufügen wird aufgerufen
            }elseif ($_GET['page'] == 'addcontact'){

                echo"
                    <div>
                        Hier kannst du Kontakte hinzufügen.
                    </div>

                    <form action ='?page=contacts' method='POST'>
                        <div>
                            <input placeholder='Name eingeben' name='name'>
                        </div>
                        
                        <div>
                            <input placeholder='Telefonnummer eingeben' name='phone'>
                        </div>
                        
                        <button type = 'submit'>Absenden</button>
                    </form>
                    ";
                    
            // Startseite wird aufgerufen
            }else{

                echo 'Du bist auf der Startseite';
            }
        ?>
        </div>
    </div>
    <div class="footer">
        (C) 2022 Carolin Birkmann GmbH
    </div>

</body>
</html>