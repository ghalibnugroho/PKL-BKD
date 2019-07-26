//<script>
     $(document).ready(function(){
        $( ".pegawai_diperintah" ).autocomplete({
          source: "<?php echo site_url('sppdController/getPegawai/?');?>"
        });
    });

  $(document).ready(
    function() {
    $(function() {
          $(".input-tanggal").datepicker({
             showButtonPanel: true,
             //minDate: new Date(),
             showTime: true
          });
       });
   });
   
	$('input[name="pengikut"]').amsifySuggestags({
    suggestionsAction : {
						url : '<?php echo site_url('sppdController/getPegawaiAll');?>'
					}
		//suggestions: ['Malang', 'Kediri', 'Madiun', 'Surabaya', 'Jayapura', 'Timika']
	});

  $('#transport').inputTags({
    autocomplete: {
        values: ['jQuery', 'tags', 'plugin', 'Javascript'],
        only: true
    },
    max: 3,
    create: function() {
        console.log('Tag added !');
    }
  });
//</script>
 