<?php
if(isset($nav_required) && $nav_required == true){
    echo '    </section>
    </main>';
}
?>
    
    </body>
</html>
<script>
const open_side_bar_icon = document.querySelector(".open_side_bar_icon");
open_side_bar_icon.onclick=e=>{
    const side_bar = document.querySelector(".sidebar");
    side_bar.classList.toggle("close");
}
</script>