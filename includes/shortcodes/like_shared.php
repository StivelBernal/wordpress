<?php

function ser_like_share_shortcode(){
    $like_count  =   get_post_meta( get_the_ID(), 's_likes_data');
    $like_count  =  !empty($like_count) ? count($like_count[0]): 0;
    echo '<div class="s_socials_shared">
                <button class="history-back"><span class="mkdf-social-icon-widget fa fa-reply"></span>'.__( 'Volver', 'serlib' ).'</button>
                <button red="facebook" class="facebook-compartir ser-shared-sn"><span class="mkdf-social-icon-widget fa fa-facebook"></span></button>
                <button red="email" class="mail-compartir ser-shared-sn"><span class="mkdf-social-icon-widget fa fa-envelope"></span></button>
                <button red="whatsapp" class="whatsapp-compartir ser-shared-sn"><span class="mkdf-social-icon-widget ion-social-whatsapp-outline"></span></button>
                <button class="me_gusta_post" id_post="'.get_the_ID().'"><span class="mkdf-social-icon-widget fa fa-heart"></span> <span class="number">'.$like_count.'</span></button>
            </div>
    ';
}



/**GUARDAR ME GUSTA */
function serlib_like_destino(){
    
    $post_ID    =   absint( $_POST['ID'] );
    $user_ID    =   get_current_user_id();
    //delete_post_meta( $post_ID, 's_likes_data', [1,2,3]);
    $post_data  =   get_post_meta( $post_ID, 's_likes_data')[0];
    if(isset($post_data)){
        
        $indice = false;

        for ($i=0; $i < count($post_data); $i++) { 
            
            if( $post_data[$i] == $user_ID){
                array_splice ( $post_data, $i ); 
                $indice = true;
            } 

        
        }
        if(!$indice){
            array_push($post_data, $user_ID);
        }

    }else{
        $post_data = [$user_ID];
    }

    update_post_meta( $post_ID, 's_likes_data', $post_data );
    echo count($post_data);
    wp_die();
}

?>

