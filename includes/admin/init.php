<?php

function serlib_admin_init(){
    include( 'columns.php' );
    include( 'enqueue.php' );

    add_filter( 'manage_destino_posts_columns', 'serlib_Add_new_destino_columns' );
    add_action( 'manage_destino_posts_custom_column', 'serlib_manage_destino_columns', 10, 2 );
    add_action( 'admin_enqueue_scripts', 'serlib_admin_enqueue' );
    add_action( 'admin_post_r_save_options', 'serlib_save_options' );
}


function extra_profile_fields( $user ) { 

    $user = get_userdata($user->ID );
    
	if(isset($user->roles)){
			
		if( $user->roles[0]  ===  'comerciante' || $user->roles[0]  ===  'pendiente_comerciante' ){
    
    ?>
   
    <h3><?php _e('Datos para verificar del comerciante'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="document_type">TIPO DE DOCUMENTO</label></th>
            <td>
            <input type="text" name="gmail" id="document_type" value="<?php echo esc_attr( get_the_author_meta( 'document_type', $user->ID ) ); ?>" class="regular-text" /><br />
            
            </td>
        </tr>
        <tr>
            <th><label for="document_number">NUMERO DE DOCUMENTO</label></th>
            <td>
            <input type="text" name="yahoo" id="document_number" value="<?php echo esc_attr( get_the_author_meta( 'document_number', $user->ID ) ); ?>" class="regular-text" /><br />
            
            </td>
        </tr>
        
        <tr>
            <th><label>ARCHIVO DOCUMENTO</label></th>
            <td>
            <a  target="_blank" href="<?php
            $FILE = esc_attr( get_the_author_meta( 'file_document', $user->ID ) );
            $FILE                = str_replace( 
                ['/home/brayan/Escritorio/FOVEA', '/home/u135059516/domains/golfodemorrosquillo.com/public_html',
                 '/home/u135059516/domains/golfodemorrosquillo.co/public_html', '/home/u135059516/domains/golfodemorrosquillo.com.co/public_html'], 
                '',
                $FILE );
            echo $FILE;
             
             ?>" >File</a><br />
            
            </td>
        </tr>
        
    </table>
<?php
        }   
    }

}
