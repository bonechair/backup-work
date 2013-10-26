<?php
/**
 * WC_Quick_View_Ultimate_Style
 *
 * Table Of Contents
 *
 * WC_Quick_View_Ultimate_Style()
 * button_style_show_on_hover()
 */
class WC_Quick_View_Ultimate_Style
{
	
	public function WC_Quick_View_Ultimate_Style(){
		//construct
	}
	
	public function button_style_show_on_hover(){
		$quick_view_ultimate_on_hover_bt_alink = get_option( 'quick_view_ultimate_on_hover_bt_alink' );
		
		?>
		<style type="text/css">
        .quick_view_ultimate_container{
			text-align:<?php echo $quick_view_ultimate_on_hover_bt_alink;?>;
			clear:both;display:
			block;
			width:100%;
			position: relative;
		}
		.quick_view_ultimate_container span{
			text-align:<?php echo $quick_view_ultimate_on_hover_bt_alink;?> !important;
			font-family: Arial, sans-serif !important;
			font-size: 14px !important;
			padding: 7px 17px !important;
			font-style:normal !important;
			font-weight:normal !important;
			background: url("/wp-content/themes/letterpress/img/quickview.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0)!important;
			position: relative;
			top:0;
			display:none;
			margin:5px 0 0 0!important;
		}
		
		.product_hover .quick_view_ultimate_container span.quick_view_ultimate_button{
			color: #FFFFFF !important;
			background: url("/wp-content/themes/letterpress/img/quickview.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
			position: absolute;
		}
		
		.quick_view_ultimate_button {
		  margin:5px 0 0 0;
		  display:block;
		  width:70px;
		  height:25px;
		}
        </style>
		<?php
	}
}
$GLOBALS['wc_quick_view_ultimate_ultimate_style'] = new WC_Quick_View_Ultimate_Style();