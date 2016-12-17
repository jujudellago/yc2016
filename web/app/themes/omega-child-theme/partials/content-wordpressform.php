<?php
/**
 * Displays a the wordpress form
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 */
?>
<style>
.form-horizontal .radio label{
	width:100%;
}
.form-horizontal label .price{
	float:right;
	
}
</style>
<article id="post-<?php the_ID();?>" <?php post_class(); ?>>
    <?php the_content( '', false ); ?>
	<form class="form-horizontal">
	<fieldset>

	<!-- Form Name -->
	<legend>Identité graphique</legend>

	<!-- Multiple Radios -->
	<div class="form-group">
	  <label class="col-md-2 control-label" for="radios">Votre logo</label>
	  <div class="col-md-6">
	  <div class="radio">
	    <label for="graphic_identity-0">
	      <input type="radio" name="graphic_identity[]" id="graphic_identity-0" value="none" checked="checked">
	      Le logo existe déjà
			<span class="price">0 chf</span>
	    </label>
		</div>
	  <div class="radio">
	    <label for="graphic_identity-1">
	      <input type="radio" name="graphic_identity[]" id="graphic_identity-1" value="freelancer">
	      Sélection d'un logo sur proposition de 3 modèles 
			<span class="price">150 chf</span>	
	    </label>
		</div>
	  <div class="radio">
	    <label for="graphic_identity-2">
	      <input type="radio" name="graphic_identity[]" id="graphic_identity-2" value="agency">
	      Création originale par freelancers
			<span class="price">1000 chf</span>	
	
	    </label>
		</div>
	  <div class="radio">
	    <label for="graphic_identity-3">
	      <input type="radio" name="graphic_identity[]" id="graphic_identity-3" value="">
	      Création originale par agence de graphisme
		  <span class="price">2000 chf</span>	
	
	    </label>
		</div>
	  </div>
	</div>
	</fieldset>



<br />

<fieldset>

<!-- Form Name -->
<legend>Design du site</legend>


	<!-- Multiple Radios -->
	<div class="form-group">
	  <label class="col-md-2 control-label" for="radios">Thème</label>
	  <div class="col-md-6">
	  <div class="radio">
	    <label for="theme-0">
	      <input type="radio" name="theme[]" id="theme-0" value="1" checked="checked">
	      Vous choisissez votre thème vous même 
	 <span class="price">0 chf</span>	
	    </label>
		</div>
	  <div class="radio">
	    <label for="theme-1">
	      <input type="radio" name="theme[]" id="theme-1" value="2">
	      Choix parmis proposition de 3 themes adaptés à vos besoins, inclusion du logo et couleurs
	 <span class="price">125 chf</span>	
	    </label>
		</div>
	  <div class="radio">
	    <label for="theme-2">
	      <input type="radio" name="theme[]" id="theme-2" value="">
	      Création d'un thème sur mesure, graphisme fourni sous forme de maquette PSD ou PDF
		 <span class="price">2500 chf</span>	
	    </label>
		</div>
	  <div class="radio">
	    <label for="theme-3">
	      <input type="radio" name="theme[]" id="theme-3" value="">
	      Création d'un thème sur mesure avec recherche graphique
		 <span class="price">4500 chf</span>	
	    </label>
		</div>
	  </div>
	</div>


	</fieldset>
	</form>


    <?php if( get_post_meta( $post->ID, THEME_SHORT. '_bullet_nav', true ) === 'show' ): ?>
    	<div class="bullet-nav" data-show-tooltips="<?php echo get_post_meta( $post->ID, THEME_SHORT. '_bullet_nav_tooltips', true ); ?>">
            <ul></ul>
        </div>
    <?php endif; ?>
    <?php oxy_atom_author_meta(); ?>
</article>
