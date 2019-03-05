<?php get_header();?>
<div class="generate-elmn-wrapper" style="width: 70%;margin: 100px auto;background: #f1f1f1;padding:20px 30px;">
	<?php
		$controls = new Export_Controls();
		$name     = isset($_GET['filename']) ? $_GET['filename'] : '';
		$files = array_diff(scandir(get_stylesheet_directory() . '/data/'), array('..', '.'));
		echo '<div class="lwwb-list-left">';
		echo '<h3> List elmn link</h3>';
		echo '<ul>';
		foreach ( $files as $file ) {
			echo '<li><a href="'.home_url('/').'?filename='.$file.'" target="_self">'.$file.'</a></li>';
		}
		echo '</ul>';
        echo '</div>';
		if ($name == ''){
			return ;
		}

		$rows = $controls->csv_to_array( $name );

		$controls_data = '<textarea>return array(';
        echo '<div class="lwwb-content">';
		foreach ( $rows as $row ) {
			if ( $row['tabs'] != '' ) {
				$controls_data .= ');</textarea><br>/**====================' . $row['tabs'] . '====================*/<br><a style="text-decoration:none;background: #11ffa9;padding: 4px;" class="btn-'.strtolower($row['tabs']).'" href="javascript:void(0);">Copy '.$row['tabs'].'</a><br><textarea class="code-'.strtolower($row['tabs']).'">return array(';
				continue;
			}
			if ( $row['modal_wrapper'] != '' ) {
				if ( $row['modal_wrapper'] === 'open' ) {
					$controls_data .= "'fields' => array(";
				}
				if ( $row['modal_wrapper'] === 'close' ) {
					$controls_data .= '),),';
				}
				continue;
			}
			if ( $row['type'] != '' ) {
				$controls_data .= $controls->get_control_config( $row );
			}
		}
		$controls_data .= ');</textarea><br>';
		$controls_data = str_replace( ',,', ',', $controls_data );

		echo '<code>'.$controls_data.'</code>';
        echo '</div>';
	?>
</div>
<style>
    .generate-elmn-wrapper .lwwb-list-left {
        float: left;
        width: 30%;
    }
    .generate-elmn-wrapper .lwwb-content {
        display: inline-block;
        width: 70%;
    }
    .generate-elmn-wrapper textarea {
        width: 100%;
        height: 150px;
        display: none;
    }
    .generate-elmn-wrapper textarea.code-content,
    .generate-elmn-wrapper textarea.code-style {
        display: block;
    }

</style>
<script>
    document.querySelector(".btn-content").onclick = function(){
        document.querySelector(".code-content").select();
        document.execCommand('copy');
    };
    document.querySelector(".btn-style").onclick = function(){
        document.querySelector(".code-style").select();
        document.execCommand('copy');
    };
</script>
<?php get_footer();?>