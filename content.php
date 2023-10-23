<?php $module = !empty($_GET['module']) ? $_GET['module'] : '' ?>


<?php if ($module == '' or $module == 'home') : 
    
     include "home.php"; 
    
    ?>
              <?php 

                elseif ($module == 'siswa') :

                    include "module/siswa/siswa-view.php";

                elseif ($module == 'user') :
                    
                    include "module/user/user-view.php";


                elseif ($module == 'buku') :
                    
                    include "module/buku/buku-view.php";

                elseif ($module == 'pustaka') :
                    
                    include "module/pustaka/pustaka-peminjaman.php";

                elseif ($module == 'pengembalian') :
                    
                    include "module/pengembalian/pengembalian-view.php";

                elseif ($module == 'game') :
                    
                    include "module/game/tictactoe.php"; 



                 endif; 

                 
                 ?>