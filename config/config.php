<?php
try {
     $db = new PDO("mysql:host=localhost;dbname=upzon;charset=utf8", "root", "passwordifyouhave");
} catch ( PDOException $e ){
     print $e->getMessage();
}

function csjs(){
     $temp=
     '
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
     '
        ;
     return$temp;
   }
