require('./uploadreducer');

(function($) {
	//hide the importer upload field on load
	$("div.csv-importer").entwine({
		onmatch: function() {
			this.hide();
		}
	});

	$.entwine('ss', function($) {
		$('.ss-gridfield .btn.toggle-csv-fields').entwine({
			//show upload field when button is clicked
			onclick: function(){
				//change entwine scope
				$('div.csv-importer').entwine('.', function($){
					this.toggle();
				});
			}
		});
	});

}(jQuery));
