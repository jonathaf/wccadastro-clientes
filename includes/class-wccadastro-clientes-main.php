<?php
class WC_Cadastro_de_clientes_main{
//Campos de cadastro extras
public function validaCPF($cpf) {
 
	// Extrai somente os números
	$cpf = preg_replace( '/[^0-9]/is', '', $cpf );
	 
	// Verifica se foi informado todos os digitos corretamente
	if (strlen($cpf) != 11) {
			return false;
	}

	// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
	if (preg_match('/(\d)\1{10}/', $cpf)) {
			return false;
	}

	// Faz o calculo para validar o CPF
	for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
					return false;
			}
	}
	return true;

}
public function validaCNPJ($cnpj = null) {

// Verifica se um número foi informado
if(empty($cnpj)) {
	return false;
}

// Elimina possivel mascara
$cnpj = preg_replace("/[^0-9]/", "", $cnpj);
$cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

// Verifica se o numero de digitos informados é igual a 11 
if (strlen($cnpj) != 14) {
	return false;
}

// Verifica se nenhuma das sequências invalidas abaixo 
// foi digitada. Caso afirmativo, retorna falso
else if ($cnpj == '00000000000000' || 
	$cnpj == '11111111111111' || 
	$cnpj == '22222222222222' || 
	$cnpj == '33333333333333' || 
	$cnpj == '44444444444444' || 
	$cnpj == '55555555555555' || 
	$cnpj == '66666666666666' || 
	$cnpj == '77777777777777' || 
	$cnpj == '88888888888888' || 
	$cnpj == '99999999999999') {
	return false;
	
 // Calcula os digitos verificadores para verificar se o
 // CPF é válido
 } else {   
 
	$j = 5;
	$k = 6;
	$soma1 = "";
	$soma2 = "";

	for ($i = 0; $i < 13; $i++) {

		$j = $j == 1 ? 9 : $j;
		$k = $k == 1 ? 9 : $k;

		$soma2 += ($cnpj{$i} * $k);

		if ($i < 12) {
			$soma1 += ($cnpj{$i} * $j);
		}

		$k--;
		$j--;

	}

	$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
	$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

	return (($cnpj{12} == $digito1) and ($cnpj{13} == $digito2));
 
}
}
public function get_user_by_meta_data( $meta_key, $meta_value ) {

$user_query = new WP_User_Query(
	array(
		'meta_key'	  =>	$meta_key,
		'meta_value'	=>	$meta_value
	)
);

$users = $user_query->get_results();

return $users;

} 

public function my_custom_js() {
	echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>';
}

public function customJsScript()
{
if(!empty( $_POST['billing_sex']))
{
	$sexo = $_POST['billing_sex'];
	
	echo "<script>val = '".$sexo."';
	jQuery('#billing_sex').val(val);
	</script>";
}

if(!empty( $_POST['billing_persontype']))
{
	$tipo = $_POST['billing_persontype'];
	
	echo "<script>val = '".$tipo."';
	jQuery('#billing_persontype').val(val);
	</script>";
	
	if($tipo == 2)
	{
		echo '<script>
		jQuery("#billing_company_field").show();
			jQuery("#billing_cnpj_field").show();
		jQuery("#billing_ie_field").show();
		jQuery("#billing_cpf_field").hide();
		</script>';
			
	}
	else
	{
		echo '<script>
		jQuery("#billing_company_field").hide();
			jQuery("#billing_cnpj_field").hide();
		jQuery("#billing_ie_field").hide();
		jQuery("#billing_cpf_field").show();
		</script>';
	}
}
 
echo '<script>
jQuery(document).ready(function($){
    jQuery("#billing_cpf").mask("000.000.000-00", {reverse: true});
	jQuery("#billing_cnpj").mask("00.000.000/0000-00", {reverse: true});
	jQuery("#billing_birthdate").mask("00/00/0000", {placeholder: "__/__/____"});
	jQuery("#billing_cellphone").mask("(00) 0000-0000");
	jQuery("#billing_phone").mask("(00) 00000-0000");
}); 


tipo = jQuery("#billing_persontype").val();
	if(tipo == 2)
{
	jQuery("#billing_company_field").show();
		jQuery("#billing_cnpj_field").show();
	jQuery("#billing_ie_field").show();
	jQuery("#billing_cpf_field").hide();
}
else
{
	jQuery("#billing_company_field").hide();
		jQuery("#billing_cnpj_field").hide();
	jQuery("#billing_ie_field").hide();
	jQuery("#billing_cpf_field").show();
}


jQuery("#billing_persontype").change(function ()
{
	val = jQuery(this).val()
	if(val == 2)
{
	jQuery("#billing_company_field").show();
		jQuery("#billing_cnpj_field").show();
	jQuery("#billing_ie_field").show();
	jQuery("#billing_cpf_field").hide();
}
else
{
	jQuery("#billing_company_field").hide();
			jQuery("#billing_cnpj_field").hide();
		jQuery("#billing_ie_field").hide();
		jQuery("#billing_cpf_field").show();
}
});  

</script>';
}

public function wooc_extra_register_fields() {
		 ?>

	 

		 <p class="form-row form-row-first">

		 <label for="billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><abbr class="required" title="obrigatório"> *</abbr></label>

		 <input type="text" class="input-text" name="billing_first_name" id="billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />

		 </p>



		 <p class="form-row form-row-last">

		 <label for="billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?>&nbsp;<abbr class="required" title="obrigatório">*</abbr></label>

		 <input type="text" class="input-text" name="billing_last_name" id="billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />

		 </p>



		 <div class="clear"></div>

	<p class="form-row form-row-wide">
		<label for="billing_persontype" class="">Tipo de Pessoa&nbsp;<abbr class="required" title="obrigatório">*</abbr></label>
		<select name="billing_persontype" id="billing_persontype" class="select">
		<option value="1" selected="selected">Pessoa Física</option>
		<option value="2">Pessoa Jurídica</option>
		</select>
	</p>

	<p class="form-row form-row-wide person-type-field validate-required" id="billing_cpf_field">
		<label for="billing_cpf" class="">CPF&nbsp;<abbr class="required" title="obrigatório">*</abbr></label><span class="woocommerce-input-wrapper">
		<input type="tel" class="input-text " name="billing_cpf" id="billing_cpf" placeholder="" value="<?php if ( ! empty( $_POST['billing_cpf'] ) ) esc_attr_e( $_POST['billing_cpf'] ); ?>" maxlength="14"></span>
	</p>

	<p class="form-row form-row-wide" id="billing_company_field" data-priority="25">
		<label for="billing_company" class="">Razão Social&nbsp;<abbr class="required" title="obrigatório">*</abbr></label>
		<span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="billing_company" id="billing_company" placeholder="" value="<?php if ( ! empty( $_POST['billing_company'] ) ) esc_attr_e( $_POST['billing_company'] ); ?>" autocomplete="organization"></span>
	</p>

	<p class="form-row form-row-first person-type-field validate-required" id="billing_cnpj_field" data-priority="26">
		<label for="billing_cnpj" class="">CNPJ&nbsp;<abbr class="required" title="obrigatório">*</abbr></label>
		<span class="woocommerce-input-wrapper"><input type="tel" class="input-text " name="billing_cnpj" id="billing_cnpj" placeholder="" value="<?php if ( ! empty( $_POST['billing_cnpj'] ) ) esc_attr_e( $_POST['billing_cnpj'] ); ?>" maxlength="18"></span>
	</p>

<p class="form-row form-row-last person-type-field validate-required" id="billing_ie_field" data-priority="27"><label for="billing_ie" class="">Inscrição Estadual&nbsp;
	</label>
	<span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="billing_ie" id="billing_ie" placeholder="" value="<?php if ( ! empty( $_POST['billing_ie'] ) ) esc_attr_e( $_POST['billing_ie'] ); ?>">
	</span>
</p>

	<p class="form-row form-row-first validate-required" id="billing_birthdate_field" data-priority="31">
		<label for="billing_birthdate" class="">Data de Nascimento&nbsp;<abbr class="required" title="obrigatório">*</abbr></label>
		<span class="woocommerce-input-wrapper"><input type="tel" class="input-text  validate[required]" name="billing_birthdate" id="billing_birthdate" placeholder="" value="<?php if ( ! empty( $_POST['billing_birthdate'] ) ) esc_attr_e( $_POST['billing_birthdate'] ); ?>" maxlength="10">
		</span>
</p>

<p class="form-row form-row-last validate-required" id="billing_sex_field" data-priority="32">
	<label for="billing_sex" class="">Sexo&nbsp;<abbr class="required" title="obrigatório">*</abbr></label><span class="woocommerce-input-wrapper">
	<select name="billing_sex" id="billing_sex" class="select wc-ecfb-select validate[required]" data-allow_clear="true" data-placeholder="Selecionar" tabindex="-1" aria-hidden="true">
		<option value="">Selecionar</option>
		<option value="Feminino">Feminino</option>
		<option value="Masculino">Masculino</option>
	</select>
	</span>
</p>

<p class="form-row form-row-first">

<label for="billing_phone">Celular<span class="required"> *</span></label>

<input type="text" class="input-text" name="billing_phone" id="billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />

</p>

		 <p class="form-row form-row-last">

		 <label for="billing_cellphone"><?php _e( 'Phone', 'woocommerce' ); ?></label>

		 <input type="text" class="input-text" name="billing_cellphone" id="billing_cellphone" value="<?php if ( ! empty( $_POST['billing_cellphone'] ) ) esc_attr_e( $_POST['billing_cellphone'] ); ?>" />

		 </p>

	



		 <?php

}




public function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {

		 if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {

						$validation_errors->add( 'billing_first_name_error', __( 'O campo nome é obrigatório.', 'woocommerce' ) );

		 }



		 if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {

						$validation_errors->add( 'billing_last_name_error', __( 'O campo sobrenome é obrigatório.', 'woocommerce' ) );

		 }


if (isset( $_POST['billing_persontype'] )) 
	{
		$tipo = $_POST['billing_persontype'];
		if($tipo == 1)
		{
			if(isset($_POST['billing_cpf']) && empty( $_POST['billing_cpf']))
			{
				$validation_errors->add( 'billing_cpf_error', __( 'O campo CPF é obrigatório.', 'woocommerce' ) );
			}
			else
			{
				if(!validaCPF($_POST['billing_cpf']))
				{
					$validation_errors->add( 'billing_cpf_error', __( 'O CPF está inválido.', 'woocommerce' ) );
				}
				else
				{
					$u = get_user_by_meta_data('billing_cpf',$_POST['billing_cpf']);
					if(count($u) > 0)
					{
						$validation_errors->add( 'billing_cpf_error', __( 'Este CPF já está associado a uma conta de usuário.', 'woocommerce' ) );
					}
				}
			}
		}
		elseif($tipo == 2)
		{
			if ( isset( $_POST['billing_company'] ) && empty( $_POST['billing_company'] ) ) {

				$validation_errors->add( 'billing_company_error', __( 'O campo Razão Social é obrigatório.', 'woocommerce' ) );

			 }
			 
			if(isset($_POST['billing_cnpj']) && empty( $_POST['billing_cnpj']))
			{
				$validation_errors->add( 'billing_cnpj_error', __( 'O campo CNPJ é obrigatório.', 'woocommerce' ) );
			}
			else
			{
				if(empty(validaCNPJ($_POST['billing_cnpj'])))
				{
					 $validation_errors->add( 'billing_cnpj_error', __( 'O CNPJ está inválido.', 'woocommerce' ) );  
				}
				else
				{
					$u = get_user_by_meta_data('billing_cnpj',$_POST['billing_cnpj']);
					if(count($u) > 0)
					{
						$validation_errors->add( 'billing_cnpj_error', __( 'Este CNPJ já está associado a uma conta de usuário.', 'woocommerce' ) );
					}
				}
			}
			
			/*if(isset($_POST['billing_ie']) && empty( $_POST['billing_ie']))
			{
				$validation_errors->add( 'billing_ie_error', __( 'Insira a Inscrição Estadual corretamente ou selecione a opção Isento.', 'woocommerce' ) );
			}*/
		}

		 }



		 if ( isset( $_POST['billing_sex'] ) && empty( $_POST['billing_sex'] ) ) {

						$validation_errors->add( 'billing_sex_error', __( 'O campo sexo é obrigatório.', 'woocommerce' ) );

		 }

	if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {

						$validation_errors->add( 'billing_phone_error', __( 'O campo celular é obrigatório.', 'woocommerce' ) );

		 }

	if ( isset( $_POST['billing_birthdate'] ) && empty( $_POST['billing_birthdate'] ) ) {

						$validation_errors->add( 'billing_birthdate_error', __( 'O campo data de nascimento é obrigatório.', 'woocommerce' ) );

		 }

	

}



public function user_registration_save($user_id)
{


	if(isset($_POST['billing_first_name']))
{
	update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
			update_user_meta($user_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
			update_user_meta($user_id, 'display_name', sanitize_text_field($_POST['billing_first_name']));
}

if(isset($_POST['billing_last_name']))
{
			update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
			update_user_meta($user_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
	}

if(isset($_POST['billing_persontype']))
{
			update_user_meta($user_id, 'billing_persontype', sanitize_text_field($_POST['billing_persontype']));
	}

if(isset($_POST['billing_cpf']))
{
			update_user_meta($user_id, 'billing_cpf', sanitize_text_field($_POST['billing_cpf']));
	}

if(isset($_POST['billing_company']))
{
			update_user_meta($user_id, 'billing_company', sanitize_text_field($_POST['billing_company']));
	}

if(isset($_POST['billing_cnpj']))
{
			update_user_meta($user_id, 'billing_cnpj', sanitize_text_field($_POST['billing_cnpj']));
	}

if(isset($_POST['billing_ie']))
{
			update_user_meta($user_id, 'billing_ie', sanitize_text_field($_POST['billing_ie']));
	}

if(isset($_POST['billing_birthdate']))
{
			update_user_meta($user_id, 'billing_birthdate', sanitize_text_field($_POST['billing_birthdate']));
	}

if(isset($_POST['billing_sex']))
{
			update_user_meta($user_id, 'billing_sex', sanitize_text_field($_POST['billing_sex']));
	}

if(isset($_POST['billing_cellphone']))
{
			update_user_meta($user_id, 'billing_cellphone', sanitize_text_field($_POST['billing_cellphone']));
	}

if(isset($_POST['billing_phone']))
{
			update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
	}


}
//Campos de cadastro extras

}
?>