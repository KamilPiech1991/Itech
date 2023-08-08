<?php

/**
 * 
 * Moduł RMA do programu ntsn.serwis
 *
 * Copyright ntsn sp. z o.o.
 * Grzegorz Bizon <grzegorz.bizon@ntsn.pl>
 *
 */

?>

<div class="text-center">
<h3>Wypełnij zgłoszenie online :</h3>
<p> Prosze o uzupełnianie tylko niezbędnych danych osobowych  do wykonania naprawy. </p>
</div>

<form id="rma-form" role="form" method="POST">

	<div class="row" id="client-hardware">

		<div class="">

			<legend id="client-legend">Zgłoszenie do naprawy przez klienta</legend>

			<div id="client-new">

				<div class="form-group">
					<label for="sFName">Imię</label>
					<input class="form-control" id="sFName" name='client[sFName]' 
						placeholder="Wprowadź imię zgłaszającego">
				</div>
				
				<div class="form-group">
					<label for="sSName">Nazwisko</label>
					<input class="form-control" id="sSName" name='client[sSName]' 
						placeholder="Wprowadź nazwisko" data-bv-notempty>
				</div>
				
				<p> Jezeli potrzebujesz naprawę na firmę uzupełnij pole nip i   firmy:</p>

				<div class="form-group">
					<label for="sCompany">Firma</label>
					<input class="form-control" id="sCompany" name='client[sCompany]' placeholder="">
				</div>
				<div class="form-group">
					<label for="sNIP">NIP</label>
					<input class="form-control" id="sNIP" name='client[sNIP]' placeholder="">
				</div>

				<div class="form-group">
					<label for="sEmail">E-mail</label>
					<input type="email" class="form-control" id="sEmail" name='client[sEmail]' 
						placeholder="Wprowadź poprawny adres e-mail" data-bv-notempty>
				</div>
				
				<div class="form-group">
					<label for="sPhone">Telefon</label>
					<input class="form-control" id="sPhone" name='client[sPhone]' 
						placeholder="Wprowadź numer telefonu" data-bv-notempty>
				</div>
				
				<hr />
				<p>Dane Adresowe:</p>
								<div class="form-group">
					<label for="sStreet">Ulica</label>
					<input class="form-control" id="sStreet" name='client[sStreet]' placeholder="">
				</div>
				<div class="form-group">
					<label for="sAddrBuild">Nr bundynku</label>
					<input class="form-control" id="sAddrBuild" name='client[sAddrBuild]' placeholder="">
				</div>
				<div class="form-group">
					<label for="sAddrLoc">Nr lokalu</label>
					<input class="form-control" id="sAddrLoc" name='client[sAddrLoc]' placeholder="">
				</div>
				<div class="form-group">
					<label for="sCity">Miasto</label>
					<input class="form-control" id="sCity" name='client[sCity]' placeholder="">
				</div>
				<div class="form-group">
					<label for="sPostal">Kod pocztowy</label>
					<input class="form-control" id="sPostal" name='client[sPostal]' placeholder="">
				</div>
				
			</div>

			<div id="client-existing" style="display: none;">
				
				<div class="form-group">
					<label for="sSName">Nazwisko</label>
					<input class="form-control" id="existing-client-name" name='eclient[sSName]' 
						placeholder="Wprowadź nazwisko" data-bv-notempty>
				</div>
				
				<div class="form-group">
					<label for="sPhone">Telefon</label>
					<input class="form-control" id="existing-client-phone" name='eclient[sPhone]' 
						placeholder="Wprowadź numer telefonu" data-bv-notempty>
				</div>

				<input type="hidden" id="existing-client-id" name="eclient[iId]">

				<button class="btn btn-primary" id="client-check-button"><b>Sprawdź poprawność danych</b></button>
				<span class="badge badge-success" id="existing-client-found" style="display: none;">
					<span class="glyphicon glyphicon-ok"></span></span>
				<br /><br />
				<div class="alert alert-danger text-center" id="existing-client-not-found" style="display: none;">
					Nie znaleziono takiego klienta w bazie danych !</div>
				
			</div>

		</div>

		<div class="">

			<legend>Sprzęt do naprawy</legend>

				<div class="form-group">
					<label for="sHName">Nazwa / Model</label>
					<input class="form-control" id="sHName" name='hardware[sHName]' 
						placeholder="Wprowadź nazwę sprzętu" data-bv-notempty>
				</div>

				<div class="form-group">
					<label for="iHType">Typ sprzętu</label>
					<select class="form-control" name="hardware[iHType]">
						<?php 
							foreach ($types as $type) {
								echo '<option value="'. $type['iTypeId'] .'">'. $type['sDescription'] .'</option>';
							}
						?>
					</select>
				</div>

				<?php
					foreach ($fields as $field) {
						?>
							<div class="form-group">
							<label for="<?= $field['sName'] ?>"><?= $field['sValue'] ?></label>
							<input class="form-control" id="<?= $field['sName'] ?>" name='hardware[<?= $field['sName'] ?>]' 
								<?= ($field['bRequired'] == 1) ? 'placeholder="Wprowadź wartość" data-bv-notempty' : '' ?>>
							</div>
						
						<?php
					}
				?>


		</div>
	</div>

	<div class="row" id="repair" style="display: none;">

		<div class="col-md-8 col-md-offset-2">

			<legend>Naprawa urządzenia:</legend>

				<div class="form-group">
					<label for="iType">Typ naprawy</label>
					<select class="form-control" id="iType" name="repair[iType]">
						<option value="0">Niegwarancyjna</option>
						<option value="1">Gwarancyjna</option>
						<option value="2">Pogwarancyjna</option>
					
					</select>
				</div>

				<div class="form-group">
					<label for="sDefect">Opis uszkodzenia</label>
					<textarea class="form-control" id="sDefect" name='repair[sDefect]' 
						placeholder="Wprowowadź opis uszkodzenia" data-bv-notempty rows="8"></textarea>
				</div>

				<div class="form-group">
					<label for="sComment">Komentarz</label>
					<textarea class="form-control" id="sComment" name='repair[sComment]' 
						placeholder="Opcjonalnie wprowadź komentarz do naprawy"></textarea>
				</div>

		</div>
	</div>

	<div class="row col-md-10 col-md-offset-1 text-right">

		<button class="btn btn-primary" id="back-button" style="display: none;"><span class="glyphicon glyphicon-chevron-left"></span>
			<b>Wstecz</b></button>
		<button class="btn btn-success" id="next-button">
			<b>Dalej</b> <span class="glyphicon glyphicon-chevron-right"></span></button>
		<button class="btn btn-success" id="submit-button" style="display: none;">
			<b>Zapisz zgłoszenie</b> <span class="glyphicon glyphicon-plus"></span></button>

	</div>

</form>


<div style="margin-top: 50px;"> &nbsp; </div>

<script type="text/coffeescript">

  $ ->

    form = $('#rma-form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      message: 'Wartość jest nieprawidłowa !',
      submitButtons: 'button[type="submit"]',
    }).data('bootstrapValidator')

    toggle_elements_visibility = (element_hide, element_show) ->
      $(element_hide).fadeOut()
      $(element_show).fadeIn()

    switch_class = (element, remove_class, add_class) ->
      $(element).removeClass(remove_class)
      $(element).addClass(add_class)

    show_repair_page = ->
      toggle_elements_visibility '#client-hardware', '#repair'
      toggle_elements_visibility '#next-button', '#back-button'
      $('#submit-button').fadeIn()

    show_client_hardware_page = ->
      toggle_elements_visibility '#repair', '#client-hardware'
      toggle_elements_visibility '#back-button', '#next-button'
      $('#submit-button').fadeOut()

    toggle_client_tab_to = (tab) ->
      switch tab
        when 'new'
          other = 'existing'
          $('#client-legend').text('Nowy klient')
          $('#existing-client-id').val('')
        when 'existing'
          other = 'new'
          $('#client-legend').text('Istniejący klient')
      toggle_elements_visibility "#client-#{other}", "#client-#{tab}"
      switch_class "##{other}-client-button", 'btn-default', 'btn-success'
      switch_class "##{tab}-client-button", 'btn-success', 'btn-default'
      $("##{tab}-client-button").blur()
	
    check_client_credentials = ->
      $('#existing-client-not-found').fadeOut()
      $('#existing-client-found').fadeOut()
      $.ajax(
        type: 'POST'
        dataType: 'JSON'
        data: {
          'name': $('#existing-client-name').val(),
          'phone':$('#existing-client-phone').val()
        }
      ).done (client) ->
        if client.iId?
          set_client_exists(client.iId)
        else
          set_client_not_found()

    set_client_exists = (id) ->
      $('#existing-client-found').fadeIn()
      $('#existing-client-id').val(id)

    set_client_not_found = ->
      $('#existing-client-not-found').fadeIn()
      revalidate_existing_client()

    revalidate_existing_client = ->
      $('#existing-client-name').val('')
      $('#existing-client-phone').val('')
      form.revalidateField($('#existing-client-name'))
      form.revalidateField($('#existing-client-phone'))

    check_client_before_next = ->
      if using_existing_client
        unless parseInt($('#existing-client-id').val()) > 0
          revalidate_existing_client()

    using_existing_client = ->
      $('#existing-client-button').hasClass('btn-success')

    $('#client-check-button').click (e) ->
      e.preventDefault()
      form.validateField($('#existing-client-name'))
      form.validateField($('#existing-client-phone'))
      $('#existing-client-id').val('')
      valid = (form.isValidField($('#existing-client-name')) &&
        form.isValidField($('#existing-client-phone')))
      check_client_credentials() if valid

    $('#new-client-button').click (e) ->
      toggle_client_tab_to 'new'
      e.preventDefault()

    $('#existing-client-button').click (e) ->
      toggle_client_tab_to 'existing'
      e.preventDefault()
    
    $('#next-button').click (e) ->
      e.preventDefault()
      check_client_before_next()
      form.validate()
      if form.isValidContainer('#client-hardware')
        show_repair_page()
      else
        $('html, body').animate({ scrollTop: 0 }, 'slow')

    $('#back-button').click (e) ->
      e.preventDefault()
      show_client_hardware_page()

    $('#submit-button').click (e) ->
      e.preventDefault()
      form.validate()
      form.defaultSubmit() if form.isValidContainer('#repair')

</script>
