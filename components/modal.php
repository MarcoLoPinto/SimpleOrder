<?php
    //Remember to import modal.css
    $generateModal = function($id,$text){
        $htmlMod = '
            <div id="'.$id.'" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>'.$text.'</p>
                </div>
            </div>
            ';

        $htmlMod .= '
        <script>
            window.onload = function(){
                // Get the modal
                var modal = document.getElementById("'.$id.'");
        
                // Get the <span> element that closes the modal
                var span = modal.getElementsByClassName("close")[0];
        
                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }
        
                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            }
        </script>';

        echo($htmlMod);
    };
?>