<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */
// file basic
namespace Lwwb\Builder\Elmn;

use Lwwb\Builder\Base\Elmn;
use Lwwb\Customizer\Control_Manager as Control;

class Price_Table extends Elmn
{
    public $type         = 'price_table'; //đổi tên
    public $label        = 'Price Table';  //đổi tên
    public $icon         = 'fa  fa-paint-brush';  //đổi tên
    public $group        = 'extra';  
    public $key_words    = 'Price Table, content'; // 
    public $default_data = array();

    public $control_groups = array(
        'content',
        'style',
        'advanced',
        // 'background',
        // 'typography',
        // 'custom_css',
    );

    public static function get_content_controls()//copy content trên back-end
    {
        
    }

    public static function get_style_controls() //copy style trên back-end
    {
        

    }

    public function render_content() {
        echo 'ádasdasdas'; // heienr thi ra ngoai
    }

    public function content_template() {
        echo 'ádasdasdas'; // hien thi ben trong
    }   
}

/* 
b1: tải file excel trên google về lưu tên có đuôi (*.csv).
b2: lưu tại : wordpress/.../wp-content/theme/twentynineteen-child/data 
b3: vào link wordpress/.../plugin/lwwb/inc/builder/elmn/(tạo file của mình).php.
b4: lên backend bấm vào tên file vừa tải về, copy content 
và style, đưa vào nội dung của 2 hàm get_content_controls() và get_style_controls() 
ở wordpress/.../plugin/lwwb/inc/builder/elmn/(file vừa tạo)*.php 
b5: vào http://localhost/wp-elementor/wp/wordpress/wp-admin/customize.php? => website bulder 
để test.

// đổi tên 1 số biến trong hàm đầu tiên của file , đổi tên class cùng tên file
*/
