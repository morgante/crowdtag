<?php
class CrowdTag extends Plugin
{
	
	public function action_init()
	{
		$this->add_template('tag_collection', dirname(__FILE__) . '/tag_collection.php');
	}
	
	public function theme_collect_tags( $theme )
	{		
		// assign placeholder text
		$theme->form = self::form( $theme->post );
		
		// Return the output of the custom template
		return $theme->fetch( 'tag_collection' );
	}
	
	private static function form( $post )
	{
		$form = new FormUI( 'tag_collection' );
		
		$form->append( 'text', 'tag_suggestions', 'null:null', _t('Suggest tags for this post') );
		$form->append('submit', 'save', _t('Submit'));
		
		// register callback
		$form->on_success( 'CrowdTag::handle_form', $post );
		
		return $form;
	}
	
	public static function handle_form( $form, $post )
	{
		Utils::debug( $post );
		exit;
	}
}
?>
