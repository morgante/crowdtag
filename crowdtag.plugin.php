<?php
class CrowdTag extends Plugin
{
	
	public function action_init()
	{
		$this->add_template('tag_collection', dirname(__FILE__) . '/tag_collection.php');
	}
	
	public function action_plugin_activation( $file )
	{
		// create vocabulary for tag suggestions
		if ( Plugins::id_from_file($file) == Plugins::id_from_file(__FILE__) ) {
			$suggestions = Vocabulary::create( array(
				'name' => 'tag_suggestions',
				'description' => 'A vocabulary for collecting suggested tags',
				'features' => array( 'multiple', 'free' )
			));
		}
	}
	
	public function theme_collect_tags( $theme )
	{		
		$post = $theme->post;
	
		// assign the form
		$theme->form = self::form( $post );
		
		Utils::debug( Vocabulary::get('tag_suggestions')->get_object_terms( 'post', $post->id ) );
		
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
				
		$vocab = Vocabulary::get('tag_suggestions');
				
		// add a term
		$term = $vocab->add_term( $form->tag_suggestions->value );
		
		// attach it to the post
		$term->associate( 'post', $post->id );
		
	}
}
?>
